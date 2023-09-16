<?php
session_start();
include('db_connect.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username']; // Assuming the input field name is "username"
    $password = $_POST['password'];

    // Check if the credentials exist in the "employee" table
    $employee_sql = "SELECT * FROM employee WHERE employee_email = '$username' AND employee_pass = '$password'";
    $employee_result = $connection->query($employee_sql);

    // Check if the credentials exist in the "freelance" table
    $freelance_sql = "SELECT * FROM freelance WHERE std_email = '$username' AND std_pass = '$password'";
    $freelance_result = $connection->query($freelance_sql);

    if ($employee_result->num_rows == 1) {
        $row = $employee_result->fetch_assoc();
        $user_level = $row['user_level'];

        $_SESSION['employee_email'] = $username;
        $_SESSION['user_level'] = $user_level;

        if ($user_level === 'admin') {
            header("Location: adminindex.php");
            exit();
        } elseif ($user_level === 'member') {
            header("Location: index.php");
            exit();
        } elseif ($user_level === 'freelance') {
            header("Location: freelanceindex.php");
            exit();
        }
    } elseif ($freelance_result->num_rows == 1) {
        $row = $freelance_result->fetch_assoc();
        $user_level = 'freelance'; // Assuming you want freelance users to have a specific user level

        $_SESSION['employee_email'] = $username;
        $_SESSION['user_level'] = $user_level;

        header("Location: freelanceindex.php");
        exit();
    } else {
        // If the username or password is incorrect
        $_SESSION['login_error'] = "Invalid email or password";
        header("Location: login.php"); 
        exit();
    }
} else {
    // Handle the case where username or password is not set in the POST request.
    $_SESSION['login_error'] = "Please enter both email and password";
    header("Location: login.php"); 
    exit();
}

$connection->close();
?>
<------------------------------------------test-------------------------------------
// ในส่วนที่เมื่อ login สำเร็จ
if ($employee_result->num_rows == 1) {
    // ... (โค้ดอื่น ๆ ที่อยู่ในส่วนนี้)

    $_SESSION['employee_email'] = $username;
    $_SESSION['user_level'] = $user_level;
    $_SESSION['employee_id'] = $row['employee_id']; // เพิ่มการเก็บค่า employee_id

    if ($user_level === 'admin') {
        header("Location: adminindex.php");
        exit();
    } elseif ($user_level === 'member') {
        header("Location: index.php");
        exit();
    } elseif ($user_level === 'freelance') {
        header("Location: freelanceindex.php");
        exit();
    }
} elseif ($freelance_result->num_rows == 1) {
    // ... (โค้ดอื่น ๆ ที่อยู่ในส่วนนี้)

    $_SESSION['employee_email'] = $username;
    $_SESSION['user_level'] = $user_level;
    $_SESSION['std_id'] = $row['std_id']; // เพิ่มการเก็บค่า std_id

    header("Location: freelanceindex.php");
    exit();
}
