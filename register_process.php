<?php
session_start();
include('db_connect.php'); // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST['full_name'];
    $sex = $_POST['sex'];
    $telnumber = $_POST['telnumber'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // Perform input validation here (e.g., check for empty fields, validate email, etc.)
    // Add your validation code here...

    // Check if the passwords match
    if ($password !== $repeat_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        header("Location: register.php"); // Redirect back to the registration page
        exit();
    }

    // Hash the password for security (you should use a stronger hashing method)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database with 'user_level' set to 'member'
    $sql = "INSERT INTO employee (employee_name, sex, telnumber, location, employee_email, employee_pass, user_level) 
            VALUES ('$full_name', '$sex', '$telnumber', '$location', '$email', '$hashed_password', 'member')";
    
    if ($connection->query($sql) === TRUE) {
        $_SESSION['register_success'] = "Registration successful. You can now log in.";
        header("Location: login.php"); // Redirect to the login page
        exit();
    } else {
        $_SESSION['register_error'] = "Error: " . $connection->error;
        header("Location: register.php"); // Redirect back to the registration page
        exit();
    }
} else {
    header("Location: register.php"); // Redirect back to the registration page if not submitted via POST
    exit();
}

$connection->close(); // Close the database connection
?>
