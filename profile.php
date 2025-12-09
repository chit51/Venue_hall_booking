<?php 
if ($_settings->userdata('login_type') == 1) {
    echo "<script> alert('You are not allowed to access this page.'); location.replace('./')</script>";
} else {
    if ($_settings->userdata('id') > 0) {
        $qry = $conn->query("SELECT *, concat(lastname, ', ', firstname, ' ', middlename) as fullname 
                            FROM `client_list` 
                            WHERE id = '{$_settings->userdata('id')}'");

        if ($qry->num_rows > 0) {
            $res = $qry->fetch_array();
            foreach ($res as $k => $v) {
                if (!is_numeric($k)) $$k = $v;
            }

            // Full Name Validation
            if (!validateName($firstname) || !validateName($lastname) || !validateName($middlename)) {
                echo "<script>alert('Invalid name format. Only letters are allowed. Please update your profile.'); 
                location.replace('./?page=manage_account')</script>";
                exit;
            }

            // Mobile Number Validation
            if (isset($contact) && !validateIndianMobileNumber($contact)) {
                echo "<script>alert('Invalid mobile number. Please update your profile.'); 
                location.replace('./?page=manage_account')</script>";
                exit;
            }

        } else {
            echo "<script> alert('You are not allowed to access this page.'); location.replace('./')</script>";
        }
    } else {
        echo "<script> alert('You are not allowed to access this page.'); location.replace('./')</script>";
    }
}



// Function to Validate Names (First, Middle, Last)
function validateName($name) {
    // Allows only letters and spaces with at least 2 characters
    return preg_match("/^[a-zA-Z\s]{2,}$/", $name);
}

// Function to Validate Indian Mobile Number
function validateIndianMobileNumber($number) {
    // Remove spaces, hyphens, or extra characters
    $number = preg_replace('/\s+|-/', '', $number);

    // Indian Mobile Number Regex (With or Without Country Code)
    return preg_match("/^(?:\+91|91)?[6-9][0-9]{9}$/", $number);
}
?>


<style>
    #client-image{
        width:100%;
        height:25vh;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="content py-5">
    <div class="container">
        <div class="card card-outline card-maroon rounded-0 shadow">
            <div class="card-header">
                <h4 class="card-title">My Profile</h4>
                <div class="card-tools">
                    <a class="btn btn-default border-0 bg-gradient-maroon btn-flat" href="./?page=manage_account">Update Account</a>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="d-flex">
                        <div class="col-md-4">
                            <center><img src="<?= validate_image(isset($avatar) ? $avatar : "") ?>" alt="Client Image" class="bg-gradient-gray img-fluid rounded-0" id="client-image"></center>
                        </div>
                        <div class="col-md-8">
                            <dl>
                                <dt class="text-maroon">Full Name</dt>
                                <dd class="ml-4"><b><?= isset($fullname) ? $fullname : "N/A" ?></b></dd>
                                <dt class="text-maroon">Gender</dt>
                                <dd class="ml-4"><b><?= isset($gender) ? $gender : "N/A" ?></b></dd>
                                <dt class="text-maroon">Contact</dt>
                                <dd class="ml-4"><b><?= isset($contact) ? $contact : "N/A" ?></b></dd>
                                <dt class="text-maroon">Email</dt>
                                <dd class="ml-4"><b><?= isset($email) ? $email : "N/A" ?></b></dd>
                                <dt class="text-maroon">Address</dt>
                                <dd class="ml-4"><b><?= isset($address) ? $address : "N/A" ?></b></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>