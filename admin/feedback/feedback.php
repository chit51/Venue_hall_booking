
<div class="card card-outline card-maroon">
	<div class="card-header">
		<h3 class="card-title">List of Bookings</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
				</colgroup>
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

// Query to retrieve all feedback
$sql = "SELECT * FROM feedback ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Feedback</title>
    
    <!-- Bootstrap 4 CDN for styles and components -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Optional custom styles for better presentation -->
    <style>
        .feedback-card {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .feedback-card h5 {
            margin-bottom: 10px;
        }
        .feedback-card p {
            font-size: 1rem;
            color: #555;
        }
        .rating {
            font-size: 1.2rem;
        }
        .container {
            max-width: 900px;
        }
        .no-feedback {
            font-size: 1.2rem;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- Container for feedback content -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">All Feedback</h1>

        <?php
        // Check if there are any feedbacks in the database
        if ($result->num_rows > 0) {
            // Loop through and display each feedback
            while($row = $result->fetch_assoc()) {
                echo "<div class='feedback-card'>";
                echo "<h5>" . htmlspecialchars($row["name"]) . " <small> (" . htmlspecialchars($row["email"]) . ") </small></h5>";
                echo "<p class='rating'>Rating: " . str_repeat("⭐", $row["rating"]) . "</p>";
                echo "<p>" . nl2br(htmlspecialchars($row["message"])) . "</p>";
                echo "<hr>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-feedback text-center'>No feedback available.</p>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>

    <!-- Bootstrap JS and jQuery (for modals, tooltips, etc.) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
