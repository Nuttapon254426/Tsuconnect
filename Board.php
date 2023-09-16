<?php
session_start();

// เช็คว่าผู้ใช้ล็อกอินเข้าสู่ระบบหรือไม่
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['std_id'])) {
    // ถ้าไม่ได้ล็อกอิน ส่งผู้ใช้กลับไปยังหน้า login
    header("Location: login.php");
    exit();
}

// ใช้ค่า employee_id หรือ std_id ตามความเหมาะสมในหน้านี้
if (isset($_SESSION['employee_id'])) {
    $employee_id = $_SESSION['employee_id'];
    // ใช้ค่า employee_id ตามที่คุณต้องการในหน้านี้
}

if (isset($_SESSION['std_id'])) {
    $std_id = $_SESSION['std_id'];
    // ใช้ค่า std_id ตามที่คุณต้องการในหน้านี้
}


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
                include "navbar.php";
                ?>
        </div>


        <section class="contact-section section-padding section-bg" id="section_5">
            <div class="col-lg-20">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ประวัติการประกาศงาน</h6>
                    </div>
                    <div class="card-body">
                        <?php
                                     include 'jobsadd.php';
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="featured-section">

        </section>
    </main>
</body>

</html>