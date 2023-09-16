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
if (isset($_POST['delete_freelance'])) {
    $student_id = $_POST['student_id'];

    // Delete the user from the 'freelance' group
    $delete_query = "UPDATE `freelance` SET `user_level` = NULL WHERE `std_id` = '$student_id'";

    if ($connection->query($delete_query) === TRUE) {
        // Redirect back to the student information page after the update
        header("Location: cards.php"); // Change to the actual page name
        exit();
    } else {
        echo "Error deleting user from 'freelance' group: " . $connection->error;
    }
}

// Close the database connection
$connection->close();
?>
