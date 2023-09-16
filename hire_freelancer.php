<?php
include "db_connect.php";

// Check if a job_id is provided in the URL
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];

    // Create an SQL query to fetch job data based on the provided job_id
    $sql = "SELECT * FROM jobdata WHERE job_id = '$job_id'";

    // Execute the SQL query
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    // Check if job data is found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Define variables for data transfer
        $job_title = $row['job_title'];
        $job_category = $row['job_category'];
        $job_description = $row['job_description'];
        $job_budget = $row['job_butget'];
        $epm_status = 'ยังไม่ส่งมอบงาน';
        $std_id = $row['std_id']; // Get the std_id from jobdata

        // Create an SQL query to insert data into the epminfo table
        $insert_sql = "INSERT INTO epminfo (epm_title, epm_jobname, epm_description, epm_butget, epm_status, std_id) VALUES ('$job_title', '$job_category', '$job_description', '$job_budget', '$epm_status', '$std_id')";

        // Execute the SQL insert query
        $insert_result = mysqli_query($connection, $insert_sql);

        if ($insert_result) {
            echo 'ข้อมูลงานถูกจัดเก็บเรียบร้อยแล้ว';
        } else {
            echo 'เกิดข้อผิดพลาดในการจัดเก็บข้อมูลงาน: ' . mysqli_error($connection);
        }
    } else {
        echo 'ไม่พบข้อมูลงานที่คุณค้นหา';
    }
} else {
    echo 'ไม่มีรหัสงานที่ระบุ';
}

// Close the database connection
mysqli_close($connection);
?>


