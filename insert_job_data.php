<?php
// Include database connection code (similar to what you have in your existing code)
include "db_connect.php";

// Get data from the AJAX request
$data = json_decode(file_get_contents("php://input"));

// Extract data
$jobTitle = mysqli_real_escape_string($connection, $data->job_title);
$jobCategory = mysqli_real_escape_string($connection, $data->job_category);
$jobDescription = mysqli_real_escape_string($connection, $data->job_description);
$jobBudget = mysqli_real_escape_string($connection, $data->job_budget);
$stdId = mysqli_real_escape_string($connection, $data->std_id);
$employeeId = mysqli_real_escape_string($connection, $data->employee_id); // Extract employee_id

// Create an SQL query to insert data into the epminfo table
$insertSql = "INSERT INTO epminfo (epm_title, epm_jobname, epm_description, epm_butget, epm_status, std_id, employee_id) 
              VALUES ('$jobTitle', '$jobCategory', '$jobDescription', '$jobBudget', 'ยังไม่ส่งมอบงาน', '$stdId', '$employeeId')";

// Execute the SQL insert query
$insertResult = mysqli_query($connection, $insertSql);

if ($insertResult) {
    echo 'success';
} else {
    echo 'error';
}

// Close the database connection
mysqli_close($connection);
?>
