<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}

if (!isset($_SESSION['employee_email']) && !isset($_SESSION['std_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "tsufreelance";
    $connection = new mysqli($hostname, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $std_id = $_POST['std_id'];
    $std_Fname = $_POST['std_Fname'];
    $std_Lname = $_POST['std_Lname'];
    $std_faculty = $_POST['std_faculty'];
    $std_major = $_POST['std_major'];
    $address = $_POST['address'];
    $std_email = $_POST['std_email'];
    $std_tel = $_POST['std_tel'];

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
                $update_image_sql = "UPDATE freelance SET profile_image='$target_file' WHERE std_id='$std_id'";
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

    $sql = "UPDATE freelance 
            SET std_Fname='$std_Fname', std_Lname='$std_Lname', std_faculty='$std_faculty', std_major='$std_major', address='$address', std_email='$std_email', std_tel='$std_tel'
            WHERE std_id='$std_id'";

    if ($connection->query($sql) === TRUE) {
        header("Location: freelanceprofile.php"); // Redirect back to the profile page
        exit();
    } else {
        echo "Error updating record: " . $connection->error;
    }

    $connection->close();
} else {
    header("Location: freelanceprofile.php"); // Redirect back to the profile page if not a POST request
    exit();
}
?>
