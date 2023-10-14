<?php
session_start();

if (!isset($_SESSION['employee_email']) || !isset($_SESSION['employee_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Assuming you have already established a database connection
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tsufreelance";
$connection = new mysqli($hostname, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$user_id = $_SESSION['employee_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $new_name = $_POST['employee_name'];
    $new_sex = $_POST['sex'];
    $new_telnumber = $_POST['telnumber'];
    $new_email = $_POST['employee_email'];

    // Handle the uploaded profile image
    if (isset($_FILES["profile_image"]) && !empty($_FILES["profile_image"])) {
        $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];
        $uploaded_file_mime_type = mime_content_type($_FILES["profile_image"]["tmp_name"]);

        if (in_array($uploaded_file_mime_type, $allowed_mime_types)) {
            // Move the uploaded file to a directory on your server
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);

            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                // Update the user's profile image in the database
                $update_image_sql = "UPDATE employee SET profile_image='$target_file' WHERE employee_id=$user_id";
                if ($connection->query($update_image_sql) !== TRUE) {
                    echo "Error updating profile image: " . $connection->error;
                }
            } else {
                echo "Error uploading image: " . $_FILES["profile_image"]["error"];
            }
        } else {
            echo "Error: The uploaded file is not a valid image file.";
        }
    }

    // Update other user profile details
    $update_sql = "UPDATE employee SET employee_name='$new_name', sex='$new_sex', telnumber='$new_telnumber', employee_email='$new_email' WHERE employee_id=$user_id";

    if ($connection->query($update_sql) === TRUE) {
        // Profile updated successfully, you can redirect to the profile page or show a success message
        header("Location: profile.php"); // Redirect to the profile page
        exit();
    } else {
        echo "Error updating record: " . $connection->error;
    }
}

// Close the database connection
$connection->close();
?>
