<?php
// This should be the very first line of your script
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$hostname = "localhost";
$username = "root";
$password = "";
$database = "tsufreelance";

// Create a database connection
$connection = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// ตรวจสอบว่ามี session std_id หรือไม่
if (isset($_SESSION['std_id'])) {
    $std_id = $_SESSION['std_id'];

    // SQL query เพื่อดึงข้อมูลของ std_id ที่ตรงกัน
    $sql = "SELECT * FROM jobdata WHERE std_id = '$std_id'";

    $result = $connection->query($sql);

    // Check for query errors
    if (!$result) {
        die("Query failed: " . $connection->error);
    }

    if ($result->num_rows > 0) {
        // เริ่มตาราง HTML with Bootstrap 5 classes
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Job ID</th><th>Job Title</th><th>Job Description</th><th>Job Budget</th><th>Job Category</th><th>Image</th><th>Upload Date</th></tr></thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            // แสดงข้อมูลในแต่ละแถวของตาราง
            echo "<tr>";
            echo "<td>" . (isset($row['job_id']) ? $row['job_id'] : 'N/A') . "</td>";
            echo "<td>" . (isset($row['job_title']) ? $row['job_title'] : 'N/A') . "</td>";
            echo "<td>" . (isset($row['job_description']) ? $row['job_description'] : 'N/A') . "</td>";
            echo "<td>" . (isset($row['job_butget']) ? $row['job_butget'] : 'N/A') . "</td>";
            echo "<td>" . (isset($row['job_category']) ? $row['job_category'] : 'N/A') . "</td>";
            echo "<td><img src='" . (isset($row['image_path']) ? $row['image_path'] : '') . "' alt='Job Image' width='100'></td>";
            echo "<td>" . (isset($row['upload_date']) ? $row['upload_date'] : 'N/A') . "</td>";
            echo "</tr>";
        }
        

        echo "</tbody>";
        // ปิดตาราง HTML
        echo "</table>";
    } else {
        echo "ไม่พบข้อมูลสำหรับ std_id: $std_id";
    }
} else {
    echo "Session std_id ไม่ถูกต้องหรือไม่มี";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$connection->close();
?>