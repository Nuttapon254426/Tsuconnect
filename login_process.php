<?php
session_start();
include('db_connect.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Check if the credentials exist in the "employee" table
    $employee_sql = "SELECT * FROM employee WHERE employee_email = '$username' AND employee_pass = '$password'";
    $employee_result = $connection->query($employee_sql);

    // Check if the credentials exist in the "freelance" table
    $freelance_sql = "SELECT * FROM freelance WHERE std_email = '$username' AND std_pass = '$password'";
    $freelance_result = $connection->query($freelance_sql);

    if ($employee_result->num_rows == 1) {
        $row = $employee_result->fetch_assoc();
        $user_level = $row['user_level'];
        $employee_id = $row['employee_id']; // รับค่า employee_id จากฐานข้อมูล
    
        $_SESSION['employee_email'] = $username;
        $_SESSION['user_level'] = $user_level;
        $_SESSION['employee_id'] = $employee_id; // เก็บค่า employee_id ใน session
    
        if ($user_level === 'admin') {
            header("Location: adminindex.php");
            exit();
        } elseif ($user_level === 'member') {
            header("Location: memberindex.php");
            exit();
        } elseif ($user_level === 'freelance') {
            header("Location: freelanceindex.php");
            exit();
        }
    } elseif ($freelance_result->num_rows == 1) {
        $row = $freelance_result->fetch_assoc();
        $user_level = 'freelance'; // Assuming you want freelance users to have a specific user level
        $std_id = $row['std_id']; // รับค่า std_id จากฐานข้อมูล
    
        $_SESSION['employee_email'] = $username;
        $_SESSION['user_level'] = $user_level;
        $_SESSION['std_id'] = $std_id; // เก็บค่า std_id ใน session
    
        header("Location: freelanceindex.php");
        exit();
    } else {
        // Login failed
        header("Location: login.php");
        exit();
    }
}

$connection->close(); // ปิดการเชื่อมต่อกับฐานข้อมูลที่นี่หลังจากใช้ฐานข้อมูลเสร็จแล้ว
?>
