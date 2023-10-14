<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection code
    include "db_connect.php"; // Correct the filename here

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $itemId = $_POST["itemId"];
    $rating = $_POST["rating"];

    // Update the rating in the database (You should add input validation and security measures here)
    $updateSql = "UPDATE `epminfo` SET `epm_rating` = $rating WHERE `epm_id` = $itemId";
    if ($connection->query($updateSql) === TRUE) {
        echo "Rating updated successfully";
    } else {
        echo "Error updating rating: " . $connection->error;
    }

    $connection->close(); // Correct the variable name here
}

?>
