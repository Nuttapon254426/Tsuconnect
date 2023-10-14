<?php
// Include your database connection script
include "db_connect.php";

// Include your navigation bar, which may contain HTML or other output
include "membernav.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}

// Check if the user is logged in
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['std_id'])) {
    header("Location: login.php");
    exit();
}

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

        // Create SQL queries to count the jobs with different statuses
        $deliveredJobsSql = "SELECT COUNT(*) AS delivered_jobs FROM epminfo WHERE epm_status = 'ส่งมอบงานแล้ว' AND std_id = '$std_id'";
        $notDeliveredJobsSql = "SELECT COUNT(*) AS not_delivered_jobs FROM epminfo WHERE epm_status = 'ยังไม่ส่งมอบงาน' AND std_id = '$std_id'";

        // Execute the SQL queries
        $deliveredJobsResult = mysqli_query($connection, $deliveredJobsSql);
        $notDeliveredJobsResult = mysqli_query($connection, $notDeliveredJobsSql);

        // Check if the queries were successful
        if ($deliveredJobsResult && $notDeliveredJobsResult) {
            $deliveredJobsRow = mysqli_fetch_assoc($deliveredJobsResult);
            $notDeliveredJobsRow = mysqli_fetch_assoc($notDeliveredJobsResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
    <title>โปรไฟล์ฟรีแลนซ์</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        img {
            display: block;
            margin: 0 auto;
            max-width: 200px;
            border-radius: 10px;
        }

        p {
            font-size: 18px;
            color: #555;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>โปรไฟล์ฟรีแลนซ์</h1>
        <?php
        if (!empty($freelancer['profile_image'])) {
            echo '<img src="' . $freelancer['profile_image'] . '" alt="Profile Image">';
        } else {
            echo '<p>No profile image available.</p>';
        }
        ?>
        <p>ชื่อ: <?php echo $freelancer['std_Fname'] . ' ' . $freelancer['std_Lname']; ?></p>
        <p>Email: <?php echo $freelancer['std_email']; ?></p>
        <p>เบอร์โทร: <?php echo $freelancer['std_tel']; ?></p>

        <!-- Display the number of delivered and not delivered jobs -->
        <p>งานที่ส่งมอบแล้ว: <?php echo $deliveredJobsRow['delivered_jobs']; ?> งาน</p>
        <p>งานที่ยังไม่ส่งมอบ: <?php echo $notDeliveredJobsRow['not_delivered_jobs']; ?> งาน</p>
        <!-- Add more profile information here as needed -->
    </div>
</body>
</html>

<?php
        } else {
            echo 'เกิดข้อผิดพลาดในการคำนวณจำนวนงาน';
        }
    } else {
        echo 'ไม่พบโปรไฟล์ฟรีแลนซ์ที่คุณค้นหา';
    }
} else {
    echo 'ไม่มีรหัสฟรีแลนซ์ที่ระบุ';
}

// Close the database connection
mysqli_close($connection);
?>
<?php
 include "freerating.php";
?>