<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['std_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection script
include "db_connect.php";

// Check if you have an identifier to fetch the freelancer's profile (e.g., std_id)
if (isset($_GET['std_id'])) {
    $std_id = $_GET['std_id'];

    // Create an SQL query to fetch the freelancer's profile data
    $sql = "SELECT * FROM freelance WHERE std_id = '$std_id'";

    // Execute the SQL query
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    // Check if profile data is found
    if (mysqli_num_rows($result) > 0) {
        $freelancer = mysqli_fetch_assoc($result);

        // Display the freelancer's profile information
        echo '<div class="container">';
        echo '<h1>โปรไฟล์ฟรีแลนซ์</h1>';
        echo '<p>ชื่อ: ' . $freelancer['std_Fname'] . ' ' . $freelancer['std_Lname'] . '</p>';
        echo '<p>Email: ' . $freelancer['std_email'] . '</p>';
        echo '<p>เบอร์โทร: ' . $freelancer['std_tel'] . '</p>';
        // Add more profile information here as needed

        echo '</div>'; // Close the container
    } else {
        echo 'ไม่พบโปรไฟล์ฟรีแลนซ์ที่คุณค้นหา';
    }
} else {
    echo 'ไม่มีรหัสฟรีแลนซ์ที่ระบุ';
}

// Close the database connection
mysqli_close($connection);
?>
