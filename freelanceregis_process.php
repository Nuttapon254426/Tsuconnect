<?php
include "db_connect.php"; // เชื่อมต่อฐานข้อมูล

// รับค่าจากแบบฟอร์ม
$std_id = $_POST['std_id'];
$std_email = $_POST['std_email'];
$std_pass = $_POST['std_pass'];

// ค้นหา std_id ในฐานข้อมูล
$sql = "SELECT * FROM `freelance` WHERE `std_id` = '$std_id'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    // พบ std_id ในฐานข้อมูล
    // อัพเดต std_email และ std_pass ในแถวนี้
    $updateSql = "UPDATE `freelance` SET `std_email` = '$std_email', `std_pass` = '$std_pass' WHERE `std_id` = '$std_id'";

    if (mysqli_query($connection, $updateSql)) {
        // อัพเดตข้อมูลสำเร็จ
        // Redirect ไปหน้า login.php หรือทำอะไรตามที่คุณต้องการ
        header("Location: login.php");
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($connection);
    }
} else {
    // ไม่พบ std_id ในฐานข้อมูล
    echo "ไม่พบข้อมูลนิสิตรหัส: $std_id ในระบบ";
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($connection);
?>
