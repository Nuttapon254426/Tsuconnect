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
} else {
    // echo "Connected successfully";
    // You can add your database operations here
}
?>
