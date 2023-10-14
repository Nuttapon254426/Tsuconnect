<?php
    include "membernav.php";
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Rest of your code...

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['std_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
include "db_connect.php";

// Assuming you have an employee_id variable available (e.g., from a session)
$employee_id = $_SESSION['employee_id']; // Adjust this as needed

$sql = "SELECT epm_id, epm_title, epm_jobname, epm_description, epm_butget, start_date, epm_status FROM epminfo WHERE employee_id = '$employee_id'";

// Execute the SQL query
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job History</title>

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add your custom CSS styles -->
    <style>
    body {
        font-family: 'Montserrat', sans-serif;
    }

    .navbar {
        margin-bottom: 20px; /* Add margin to create space between navbar and content */
    }

    .job-history-section {
        margin-top: 20px; /* Reduce margin-top to create space between header and table */
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        text-align: center;
    }

    .table thead th {
        background-color: #007BFF;
        color: #fff;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Your Logo</a>
        <!-- Add your navigation links here -->
    </nav>

    <main>
        <section class="job-history-section">
            <div class="container">
                <h1>ประวัติการจ้างงานของคุณ</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ชื่องาน</th>
                            <th>ประเภทงาน</th>
                            <th>รายละเอียดงาน</th>
                            <th>งบประมาณ</th>
                            <th>วันที่เริ่มงาน</th>
                            <th>สถานะงาน</th>
                            <th>การดำเนินงาน</th> <!-- Adjust this header as needed -->
                        </tr>
                    </thead>

                    <tbody>
                        <?php
// Loop through the results and display job history
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['epm_title'] . '</td>';
    echo '<td>' . $row['epm_jobname'] . '</td>';
    echo '<td>' . $row['epm_description'] . '</td>';
    echo '<td>' . $row['epm_butget'] . '</td>';
    echo '<td>' . $row['start_date'] . '</td>';
    echo '<td>' . $row['epm_status'] . '</td>';
    echo '<td><button onclick="changeStatus(' . $row['epm_id'] . ')">Change Status</button></td>';
    echo '</tr>';
}
?>

                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
<script>
function changeStatus(jobId) {
    // Assuming you have a function to make an AJAX request to update the status
    // Replace 'updateStatus.php' with the actual URL to your update script
    $.ajax({
        url: 'updateStatus.php',
        type: 'POST',
        data: {
            jobId: jobId
        },
        success: function(response) {
            if (response === 'success') {
                // Optionally, update the status text in the table cell
                // This is just an example, adjust as needed
                const statusCell = document.querySelector(`#status_${jobId}`);
                if (statusCell) {
                    statusCell.textContent = 'ส่งมอบงานแล้ว';
                }
            } else {
                alert('Failed to change status.');
            }
        },
        error: function() {
            alert('Error occurred.');
        }
    });
}
</script>

</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
