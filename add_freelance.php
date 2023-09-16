<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tsufreelance";

// Create a database connection
$connection = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the form was submitted
if (isset($_POST['add_freelance'])) {
    $student_id = $_POST['student_id'];

    // Update the user_level to "freelance" for the selected student
    $update_query = "UPDATE `freelance` SET `user_level` = 'freelance' WHERE `std_id` = '$student_id'";

    if ($connection->query($update_query) === TRUE) {
        // Redirect back to the student information page after the update
        header("Location: cards.php"); // Change to the actual page name
        exit();
    } else {
        echo "Error updating user_level: " . $connection->error;
    }
}

// Close the database connection
$connection->close();
?>
