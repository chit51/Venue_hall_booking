<?php
require_once('../../config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $rating = intval($_POST['rating']);
    $message = $conn->real_escape_string($_POST['message']);
    $created_at = date('Y-m-d H:i:s');

    // Insert into database
    $insert = $conn->query("INSERT INTO `feedback_list` (`name`, `email`, `rating`, `message`, `created_at`) 
                            VALUES ('$name', '$email', '$rating', '$message', '$created_at')");

    if ($insert) {
        echo json_encode(['status' => 'success', 'msg' => 'Thank you for your feedback!']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Failed to submit feedback. Please try again.']);
    }
}
?>
