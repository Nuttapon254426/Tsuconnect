<?php
// Include the database connection file
include_once 'db_connect.php';

// Get the skill ID from the POST request
$skill_id = $_POST['skill_id'];

// Create a query to delete the skill from the database
$sql = "DELETE FROM skilltype WHERE skill_id = $skill_id";

// Execute the query
$result = $connection->query($sql);

// Check if the query was successful
if ($result) {
    // The query was successful, so we can redirect to the home page
    header("Location: index.php");
} else {
    // The query was not successful, so we can print an error message
    echo "Error: " . $connection->error;
}

// Close the database connection
$connection->close();
?>
