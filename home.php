<style>
    .car-cover{
        width:10em;
    }
    .car-item .col-auto{
        max-width: calc(100% - 12em) !important;
    }
    .car-item:hover{
        transform:translate(0, -4px);
        background:#a5a5a521;
    }
    .banner-img-holder{
        height:25vh !important;
        width: calc(100%);
        overflow: hidden;
    }
    .banner-img{
        object-fit:scale-down;
        height: calc(100%);
        width: calc(100%);
        transition:transform .3s ease-in;
    }
    .car-item:hover .banner-img{
        transform:scale(1.3)
    }
    .welcome-content img{
        margin:.5em;
    }
</style>
<?php
require_once('./config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $rating = intval($_POST['rating']);
    $message = htmlspecialchars($_POST['message']);
    $created_at = date('Y-m-d H:i:s');

    if(empty($name) || empty($email) || empty($rating) || empty($message)) {
        echo json_encode(['status' => 'error', 'msg' => 'All fields are required.']);
        exit;
    }

    // Insert feedback into database
    $insert = $conn->query("INSERT INTO `feedback_list` (`name`, `email`, `rating`, `message`, `created_at`) 
                            VALUES ('$name', '$email', '$rating', '$message', '$created_at')");

    if($insert) {
        echo json_encode(['status' => 'success', 'msg' => 'Thank you for your feedback!']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Failed to submit feedback. Please try again.']);
    }
}
?>

<div class="col-lg-12 py-5">
    <div class="contain-fluid">
        <div class="card card-outline card-maroon shadow rounded-0">
            <div class="card-body rounded-0">
                <div class="container-fluid">
                    <h3 class="text-center">Welcome</h3>
                    <hr>
                    <div class="welcome-content">
                        <?php include("welcome.php") ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>