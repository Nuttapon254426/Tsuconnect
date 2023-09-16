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
