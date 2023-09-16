<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['employee_id'])) {
    // If not logged in, redirect the user to the login page
    header("Location: login.php");
    exit();
}

// Create a database connection (assuming you already have this code)
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tsufreelance";
$connection = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the employee_id or std_id from the session
if (isset($_SESSION['employee_id'])) {
    $user_id = $_SESSION['employee_id'];
} elseif (isset($_SESSION['std_id'])) {
    $user_id = $_SESSION['std_id'];
}

// Fetch the employee_name from the database based on user_id
$user_name = "";
if (isset($user_id)) {
    $sql = "SELECT employee_name FROM employee WHERE employee_id = $user_id";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_name = $row['employee_name'];
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Responsive Navbar | Tsu Freelance Connect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
<nav class="fixed-top">
    <input type="checkbox" id="check">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
    </label>
    <label class="logo">Tsu Freelance Connect</label>
    <ul>
        <li><a class="active" href="memberindex.php">Home</a></li>
        <li><a href="#">บอร์ดประกาศงาน</a></li>
        <li><a href="#">ประวัติการประกาศงาน</a></li>
        <li class="dropdown">
    <a href="#" class="dropbtn"><span>หมวดหมู่</span></a>
    <div class="dropdown-content">
          <?php
        // Fetch skill names from the skilltype table
        $sql = "SELECT skill_name FROM skilltype";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $skill_name = $row["skill_name"];
                // Link to jobcategory.php with the selected skill category as a parameter
                echo '<a href="memberjobcategory.php?skill=' . urlencode($skill_name) . '">' . $skill_name . '</a>';
            }
        } else {
            echo '<a href="#">No skill categories available</a>';
        }

        // Close the database connection (if needed)
        // $connection->close();
        ?>
    </div>
</li>
        <li class="dropdown">
                <a href="#" class="dropbtn"><span>ยินดีต้อนรับสมาชิก : <?php echo $user_name; ?></span></a>
                <div class="dropdown-content">
                    <a href="memberprofile.php">แก้ไขโปรไฟล์</a>
                    <a href="#">Item 2</a>
                    <a href="#">Item 3</a>
                </div>
            </li>
            <li><a class="btn btn-primary" href="#" onclick="confirmLogout()">ออกจากระบบ</a></li>
        
       
    </ul>
</nav>
</body>
</html>
<script>
function confirmLogout() {
    if (confirm("คุณต้องการออกจากระบบใช่หรือไม่?")) {
        // If the user confirms, redirect to the logout.php page
        window.location.href = "logout.php";
    }
}
</script>