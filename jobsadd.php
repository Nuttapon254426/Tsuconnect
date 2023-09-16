<!DOCTYPE html>
<html>

<head>
    <title>Job Data Form</title>
    <!-- Include Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">บอร์ดประกาศงาน</h1>
        <form action="job_process.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="job_title" class="form-label">ชื่องาน:</label>
                <input type="text" id="job_title" name="job_title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="job_description" class="form-label">คำอธิบายงาน:</label>
                <textarea id="job_description" name="job_description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="job_butget" class="form-label">งบประมาณงาน:</label>
                <input type="number" id="job_butget" name="job_butget" class="form-control" required>
            </div>

            <?php
include "db_connect.php"; // นำเข้าไฟล์เชื่อมต่อฐานข้อมูล

$sql = "SELECT skill_name FROM skilltype";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // สร้าง dropdown list
    echo '<div class="mb-3">';
    echo '<label for="job_category" class="form-label">หมวดหมู่งาน:</label>';
    echo '<select id="job_category" name="job_category" class="form-control" required>';
    
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['skill_name'] . '">' . $row['skill_name'] . '</option>';
    }

    echo '</select>';
    echo '</div>';
} else {
    echo "ไม่พบข้อมูลในตาราง skilltype";
}

// ปิดการเชื่อมต่อฐานข้อมูล (ใช้ $connection->close() แทน)
$connection->close();
?>


            <div class="mb-3">
                <label for="image" class="form-label">เพิ่มรูปภาพ:</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">ยืนยัน</button>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS and jQuery (optional) for additional functionality -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>