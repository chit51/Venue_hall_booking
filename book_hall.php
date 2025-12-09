<?php 
require_once('./config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT b.*,h.name as `hall` from `booking_list` b inner join `hall_list` h on b.hall_id = h.id where b.id in ({$_GET['id']}) ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
            $services_ids = explode(',', str_replace("|","",$services_ids));
    }
}
?><div class="container-fluid">
    <form action="" id="book-form">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <input type="hidden" name="client_id" value="<?= $_settings->userdata('id') ?>">

        <!-- Hall Selection -->
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="hall_id" class="control-label">Hall</label>
                <select name="hall_id" id="hall_id" class="form-control form-control-sm form-control-border select2" required>
                    <option value="" disabled="disabled" <?= !isset($hall_id) ? 'selected' : '' ?>></option>
                    <?php 
                    $hall = $conn->query("SELECT * FROM `hall_list` where delete_flag = 0 and status = 1 ".(isset($hall_id) ? " or id = '{$hall_id}'" : "")." order by `name` asc");
                    while($row= $hall->fetch_assoc()):
                    ?>
                        <option value="<?= $row['id'] ?>"><?= $row['code']. " - " .$row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <!-- Services Selection -->
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="services_ids" class="control-label">Services</label>
                <select name="services_ids[]" id="services_ids" class="form-control form-control-sm form-control-border select2" multiple required>
                    <?php 
                    $service = $conn->query("SELECT * FROM `service_list` where delete_flag = 0 and status = 1 ".(isset($services_ids) ? " or id in (".(implode(',',$services_ids)).")" : "")." order by `name` asc");
                    while($row= $service->fetch_assoc()):
                    ?>
                        <option value="<?= $row['id'] ?>" <?= isset($services_ids) && in_array($row['id'], $services_ids) ? "selected" : '' ?>><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <!-- Wedding Schedule and Total Guests -->
        <div class="row">
           <div class="col-md-6 form-group">
                <label for="wedding_schedule" class="control-label">Wedding Schedule</label>
                <input type="date" id="wedding_schedule"  name="wedding_schedule" min="<?php echo date('Y-m-d');?>" class="form-control form-control-sm form-control-border" required>
            </div>
            
            <div class="col-md-6 form-group">
                <label for="total_guests" class="control-label">Total Guests</label>
                <input type="number" id="total_guests" name="total_guests" value="<?= isset($total_guests) ? $total_guests : "" ?>" class="form-control form-control-sm form-control-border text-right" oninput="validateGuestInput(this)" required>
            </div>
        </div>

       

        <!-- Remarks -->
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="remarks" class="control-label">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3" required><?= isset($remarks) ? $remarks : "" ?></textarea>
            </div>
        </div>

    </form>
</div>

<script>
   function validateGuestInput(input) {
    if (input.value < 1) {
        input.value = "";  // Clear invalid value
        alert("Please enter a valid number greater than zero for Total Guests.");
    }
}

$(function(){
    // Initialize select2
    $('#uni_modal').on('shown.bs.modal', function(){
        $('.select2').select2({
            placeholder:"Please select here",
            width:"100%",
            dropdownParent:$('#uni_modal')
        });
    });

    $('#uni_modal').trigger('shown.bs.modal');

    // Show/hide card payment details based on payment method
    $('#payment_method').change(function() {
        if ($(this).val() === 'card') {
            $('#card-payment-details').show();
        } else {
            $('#card-payment-details').hide();
        }
    });

    // Form submission handling
    $('#uni_modal #book-form').submit(function(e){
        e.preventDefault();

        var totalGuests = $('#total_guests').val();
        var paymentMethod = $('#payment_method').val();
        var cardNumber = $('#card_number').val();
        var cardHolderName = $('#card_holder_name').val();
        var expDate = $('#exp_date').val();
        var cvv = $('#cvv').val();

        // Validate Total Guests
        if (totalGuests <= 0 || isNaN(totalGuests)) {
            alert("Total Guests must be a positive number.");
            $('#total_guests').focus();
            return false;  // Prevents submission
        }

        // If payment is by card, validate card details
        if (paymentMethod === 'card') {
            if (!cardHolderName || !cardNumber || !expDate || !cvv) {
                alert("Please fill in all card details.");
                return false;
            }
            // Optional: Add further validation for card number format, CVV, and expiration date if needed
        }

        var _this = $(this);
        $('.pop-msg').remove();
        var el = $('<div>').addClass("pop-msg alert").hide();

        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_book",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error: err => {
                console.log("Error:", err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp){
                if (resp.status == 'success') {
                    location.href = './?page=my_bookings';
                } else if (!!resp.msg) {
                    el.addClass("alert-danger").text(resp.msg);
                    _this.prepend(el);
                } else {
                    el.addClass("alert-danger").text("An error occurred due to an unknown reason.");
                    _this.prepend(el);
                }
                el.show('slow');
                $('html, body, .modal').animate({scrollTop: 0}, 'fast');
                end_loader();
            }
        });
    });
});
</script>
