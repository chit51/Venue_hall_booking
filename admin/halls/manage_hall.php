<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `hall_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    #cimg{
        width:100%;
        height:15vh;
        object-fit: scale-down;
        object-position: center center
    }
</style>
<div class="container-fluid">
    <form action="" id="hall-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="code" class="control-label">Code</label>
            <input type="text" pattern="[0-9A-Za-z_-]+" maxlength="50" name="code" id="code" class="form-control form-control-border" placeholder="Hall-101" value ="<?php echo isset($code) ? $code : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="name" class="control-label">Name</label>
            <input type="text" name="name" id="name" class="form-control form-control-border" placeholder="Enter hall Name" value ="<?php echo isset($name) ? $name : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="price" class="control-label">Price</label>
            <input type="number" step="any" name="price" id="price" class="form-control form-control-border text-right" placeholder="0" value ="<?php echo isset($price) ? $price : "" ?>" oninput="validatePriceInput(this)"
             required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Description</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Hall Image</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input rounded-0" id="customFile" name="img" onchange="displayImg(this,$(this))">
                <label class="custom-file-label rounded-0" for="customFile">Choose file</label>
            </div>
        </div>
        <div class="form-group">
        <label for="location" class="control-label">Location</label>
        <input type="text" name="location" id="location" class="form-control form-control-border" placeholder="Enter hall location" value ="<?php echo isset($location) ? $location : '' ?>">
        </div>

        <div class="form-group d-flex justify-content-center">
            <img src="<?php echo validate_image(isset($image_path) ? $image_path : "") ?>" alt="" id="cimg" class="img-fluid img-thumbnail bg-gradient-gray">
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
    </form>
</div>
<script>
    function validatePriceInput(input) {
    if (parseFloat(input.value) <= 0 || isNaN(input.value)) {
        input.value = "";
        alert("Please enter a valid positive price greater than zero.");
    }
}
    function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', '<?php echo validate_image(isset($image_path) ? $image_path : "") ?>');
            _this.siblings('.custom-file-label').html('Choose file')
        }
	}
    $(function(){
        $('#uni_modal #hall-form').submit(function(e){
    e.preventDefault();

    // Price validation
    var priceValue = parseFloat($('#price').val());
    if (priceValue <= 0 || isNaN(priceValue)) {
        alert("Price must be a positive number greater than zero.");
        $('#price').focus();
        return false;
    }

    // Location validation
    var locationVal = $('#location').val().trim();
    var locationRegex = /^[A-Za-z0-9\s,.-]{3,}$/;
    if (!locationRegex.test(locationVal)) {
        alert("Please enter a valid location (minimum 3 characters, no special symbols).");
        $('#location').focus();
        return false;
    }

    // Continue with AJAX submit
    var _this = $(this);
    $('.pop-msg').remove();
    var el = $('<div>').addClass("pop-msg alert").hide();
    start_loader();
    
    $.ajax({
        url:_base_url_+"classes/Master.php?f=save_hall",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        dataType: 'json',
        error: err => {
            console.log(err)
            alert_toast("An error occurred",'error');
            end_loader();
        },
        success: function(resp){
            if(resp.status == 'success'){
                location.reload();
            } else if(!!resp.msg){
                el.addClass("alert-danger").text(resp.msg);
                _this.prepend(el);
            } else {
                el.addClass("alert-danger").text("An error occurred due to unknown reason.");
                _this.prepend(el);
            }
            el.show('slow');
            $('html,body,.modal').animate({scrollTop:0},'fast');
            end_loader();
        }
    })
});

        $('#uni_modal #hall-form').submit(function(e){
            e.preventDefault();

            var priceValue = parseFloat($('#price').val());
        if (priceValue <= 0 || isNaN(priceValue)) {
            alert("Price must be a positive number greater than zero.");
            $('#price').focus();
            return false;  // Prevents form submission
        }
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_hall",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html,body,.modal').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
        })
    })
</script>