<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "venue_hall"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $message = $_POST['message'];

    // Prepare SQL query to insert the data
    $sql = "INSERT INTO feedback (name, email, rating, message) VALUES ('$name', '$email', '$rating', '$message')";

    // Execute query and check if it's successful
    if ($conn->query($sql) === TRUE) {
        // Show success message and redirect using JavaScript
        echo "<script>
                alert('Feedback submitted successfully!');
                window.location.href = 'home.php'; // Redirect to home page
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<p style="margin-right: 0px; margin-bottom: 15px; padding: 0px;">Thank you for considering Wedding Hall Booking for your event needs. We are here to assist you in creating unforgettable moments, and your inquiries and feedback are essential to ensuring your experience with us is seamless and memorable.</p>
<p style="margin-right: 0px; margin-bottom: 15px; padding: 0px;"><br></p>
<p style="margin-right: 0px; margin-bottom: 15px; padding: 0px;">For any questions regarding venue availability, pricing, or specific requirements for your event, please don't hesitate to reach out to our dedicated team. We are committed to providing prompt and helpful assistance, guiding you through the booking process effortlessly.</p>
<p style="margin-right: 0px; margin-bottom: 15px; padding: 0px;"><br></p>
<p style="margin-right: 0px; margin-bottom: 15px; padding: 0px;">Customer satisfaction is our top priority, and your feedback is invaluable. If you have any comments, suggestions, or concerns, please feel free to share them with us. We are constantly striving to enhance our services and make your event planning journey with Wedding Hall Booking as enjoyable as possible.</p>
<p style="margin-right: 0px; margin-bottom: 15px; padding: 0px;"><br></p>
<p style="margin-right: 0px; margin-bottom: 15px; padding: 0px;">Contact us through the provided form on this page, and our team will get back to you promptly. Alternatively, you can reach us directly via email at Dhruvithirani@gmail.com or by phone at +91 90231 88547. We look forward to being part of your special event and ensuring it unfolds seamlessly at one of our exceptional venues. Thank you for choosing [Weddding Hall Booking].</p>
<br><p></p>

<div class="container" id="feedback-section">
    <h3 class="text-center">We Value Your Feedback</h3>
    <p class="text-center">Help us improve by sharing your thoughts!</p>

    <!-- Feedback Form -->
    <form id="feedback-form" action="submit_feedback.php" method="POST">
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required=""/>
        </div>

        <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required=""/>
        </div>

        <div class="form-group">
            <label for="rating">Rating</label>
            <select id="rating" name="rating" class="form-control" required=""/>
                <option value="" disabled="" selected="">Select a rating</option>
                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                <option value="4">⭐⭐⭐⭐ Good</option>
                <option value="3">⭐⭐⭐ Average</option>
                <option value="2">⭐⭐ Poor</option>
                <option value="1">⭐ Terrible</option>
            </select>
        </div>

        <div class="form-group">
            <label for="message">Your Feedback</label>
            <textarea id="message" name="message" class="form-control" rows="4" placeholder="Enter your feedback" required=""></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
</div>
    