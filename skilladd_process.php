<?php
// Include the database connection file
include_once 'db_connect.php';

// Get the skill name from the POST request
$skill_name = $_POST['skill_name'];

// Create a query to check if the skill name already exists in the database
$checkSql = "SELECT skill_id FROM skilltype WHERE skill_name = '$skill_name'";

// Execute the query
$checkResult = $connection->query($checkSql);

// Check if a skill with the same name already exists
if ($checkResult->num_rows > 0) {
    // A skill with the same name already exists, so display an error message
    echo "Skill with the same name already exists. Please choose a different name.";
    header("Location: addskill.php");
} else {
    // The skill name is unique, so you can proceed with the insertion
    // Create a query to insert the new skill into the database
    $insertSql = "INSERT INTO skilltype (skill_name) VALUES ('$skill_name')";

    // Execute the insertion query
    $insertResult = $connection->query($insertSql);

    // Check if the query was successful
    if ($insertResult) {
        // The skill was added successfully, so we can redirect to the home page
        header("Location: addskill.php");
    } else {
        // The query was not successful, so we can print an error message
        echo "Error: " . $connection->error;
    }
}

// Close the database connection
$connection->close();
?>
