<?php
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

// รับค่า employee_id และ employee_name จาก $_SESSION
$employee_id = isset($_SESSION['employee_id']) ? $_SESSION['employee_id'] : null;
$employee_name = isset($_SESSION['employee_name']) ? $_SESSION['employee_name'] : null;


// Check the user's role (freelance or member)
$userRole = isset($_SESSION['employee_email']) ? 'freelance' : 'member';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>TsuConnect</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
</head>

<body id="top">

    <main>

    <div>
            <?php
              include "membernav.php"; 
            ?>
        </div>
        <style>
        .topic-card {
            border: 1px solid #ddd;
            /* Lighter border color */
            border-radius: 10px;
            /* Slightly rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Add a subtle shadow */
            transition: transform 0.2s ease-in-out;
            /* Add a smooth hover effect */
            background-color: #fff;
            /* White background color */
            overflow: hidden;
            /* Hide any overflowing content */
            margin-bottom: 20px;
            /* Add some spacing between cards */
        }

        .topic-card:hover {
            transform: translateY(-5px);
            /* Raise the card slightly on hover */
        }

        .card-header {
            background-color: #f8f9fa;
            /* Light gray background for header */
            padding: 10px;
            /* Add some padding to the header */
            border-bottom: 1px solid #ddd;
            /* Separator line at the bottom of the header */
        }

        .card-title {
            margin-bottom: 0;
            /* Remove margin below the title */
        }

        .card-body {
            padding: 20px;
            /* Add padding to the card body */
        }

        .card-text {
            color: #333;
            /* Darker text color */
        }

        .img-fluid {
            max-width: 100%;
            /* Ensure images don't exceed their container width */
            height: auto;
            /* Maintain aspect ratio */
        }

        .limit-text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Limit to 3 lines */
            -webkit-box-orient: vertical;
        }

        .topic-card-container {
            display: flex;
            flex-wrap: wrap;
            /* ทำให้แสดงเป็นหลายระดับเมื่อจอเล็กลง */
            justify-content: space-between;
            /* กระจาย space ระหว่าง .topic-card ที่อยู่ใน container */
        }

        .topic-card {
            flex: 0 0 calc(33.33% - 20px);
            /* คำนวณความกว้างของแต่ละ .topic-card */
            /* ... (โค้ด CSS อื่น ๆ ที่คุณมี) */
            margin-bottom: 20px;
            /* Add some spacing between cards */
        }
        </style>
        <section class="explore-section section-padding" id="section_2">
            <div class="container">
                <div class="col-12 text-center">
                    <h2 class="mb-4">แสดงงานที่ค้นหา</h2>
                </div>
                <div class="row">
                    <?php
include "db_connect.php";

// ตรวจสอบคำสำคัญที่ผู้ใช้ค้นหาผ่าน URL
if (isset($_GET['search'])) {
    $search_keyword = $_GET['search'];
} else {
    // ถ้าไม่มีคำสำคัญใน URL ให้กำหนดค่าเริ่มต้นเป็นค่าว่าง
    $search_keyword = "";
}

// ตรวจสอบค่า skill_name ที่ถูกส่งมาจาก URL
if (isset($_GET['skill'])) {
    $selectedSkill = $_GET['skill'];

    // สร้างคำสั่ง SQL สำหรับค้นหางานที่มี job_category เท่ากับ skill_name
    $sql = "SELECT * FROM jobdata WHERE job_category = '$selectedSkill'";
} else {
    // ถ้าไม่มีค่า skill_name ใน URL ให้ใช้เฉพาะค่าคำสำคัญ
    $sql = "SELECT * FROM jobdata WHERE job_category LIKE '%$search_keyword%'";
}

// ดำเนินการคิวรี SQL
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("คิวรีล้มเหลว: " . mysqli_error($connection));
}

// แสดงผลรายการงานที่ตรงเงื่อนไข
while ($row = mysqli_fetch_assoc($result)) {
    // สร้างลิงก์ไปยังหน้ารายละเอียดของงาน
    $details_link = 'memberdetails.php?id=' . $row['job_id']; // แทนที่ 'details.php' ด้วย URL จริงๆ

    echo '<div class="col-md-4 mb-4">';
    echo '<a href="' . $details_link . '" class="card-link">'; // เพิ่มลิงก์
    echo '<div class="topic-card">';
    echo '<div class="card-header">';
    echo '<h3 class="card-title">' . $row['job_title'] . '</h3>';
    echo '</div>';
    echo '<div class="card-body">';
    echo '<p class="card-text limit-text">' . $row['job_description'] . '</p>'; // เพิ่มคลาสเพื่อจำกัดข้อความ
    echo '<img src="' . $row['image_path'] . '" alt="Job Image" class="img-fluid">';
    echo '<p class="card-text">งบประมาณงาน: ' . $row['job_butget'] . '</p>';
    echo '<p class="card-text">รหัสนิสิตฟรีแลนซ์: ' . $row['std_id'] . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</a>'; // ปิดลิงก์
    echo '</div>';
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($connection);
?>

    </main>
</body>

</html>