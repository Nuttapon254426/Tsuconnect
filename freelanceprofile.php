<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}

// Check if the user is logged in
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['std_id'])) {
    // If not logged in, redirect the user to the login page
    header("Location: login.php");
    exit();
}

// Assuming you have already established a database connection
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tsufreelance";
$connection = new mysqli($hostname, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$user_id = $_SESSION['std_id'];


// Fetch user information from the database based on std_id
$user_info = [];
if (isset($user_id)) {
    $sql = "SELECT * FROM freelance WHERE std_id = $user_id";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
    }
}

// Check if the page is in "edit" mode
$editMode = false;

if (isset($_GET['edit']) && $_GET['edit'] === 'true') {
    $editMode = true;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Freelance Profile | Tsu Freelance Connect</title>

    <!-- Add Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <style>
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 50px;
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-weight: 700;
        font-size: 32px;
        color: #333;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    ul li {
        margin-bottom: 10px;
    }

    .btn-secondary {
        background-color: #333;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #555;
    }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>

    <div class="container">
        <h1>Freelance Profile</h1>

        <?php if ($editMode): ?>
        <!-- Edit Profile Section -->
        <form method="post" action="update_profile.php" enctype="multipart/form-data">
            <!-- Add hidden input for std_id -->
            <input type="hidden" name="std_id" value="<?php echo $user_info['std_id']; ?>">

            <!-- Add an input field for uploading a new profile image -->
            <div class="form-group">
                <label for="profile_image">อัปโหลดรูปโปรไฟล์:</label>
                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
            </div>

            <div class="form-group">
                <label for="std_Fname">ชื่อ:</label>
                <input type="text" class="form-control" id="std_Fname" name="std_Fname"
                    value="<?php echo $user_info['std_Fname']; ?>">
            </div>
            <div class="form-group">
                <label for="std_Lname">นามสกุล:</label>
                <input type="text" class="form-control" id="std_Lname" name="std_Lname"
                    value="<?php echo $user_info['std_Lname']; ?>">
            </div>
            <div class="form-group">
                <label for="std_faculty">คณะ:</label>
                <input type="text" class="form-control" id="std_faculty" name="std_faculty"
                    value="<?php echo $user_info['std_faculty']; ?>">
            </div>
            <div class="form-group">
                <label for="std_major">สาขา:</label>
                <input type="text" class="form-control" id="std_major" name="std_major"
                    value="<?php echo $user_info['std_major']; ?>">
            </div>
            <div class="form-group">
                <label for="address">ที่อยู่:</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="<?php echo $user_info['address']; ?>">
            </div>
            <div class="form-group">
                <label for="std_email">Email:</label>
                <input type="text" class="form-control" id="std_email" name="std_email"
                    value="<?php echo $user_info['std_email']; ?>">
            </div>
            <div class="form-group">
                <label for="std_tel">เบอร์โทร:</label>
                <input type="text" class="form-control" id="std_tel" name="std_tel"
                    value="<?php echo $user_info['std_tel']; ?>">
            </div>
            <!-- Add input fields for other profile information here -->

            <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
        </form>
        <?php else: ?>
        <!-- View Profile Section -->
        <!-- Display the profile image -->
        <?php if (!empty($user_info['profile_image'])): ?>
        <img src="<?php echo $user_info['profile_image']; ?>" alt="Profile Image" class="img-thumbnail"
            style="max-width: 200px;">
        <?php else: ?>
        <p>No profile image available.</p>
        <?php endif; ?>
        <ul>
            <li><strong>ชื่อ:</strong> <?php echo $user_info['std_Fname']; ?></li>
            <li><strong>นามสกุล:</strong> <?php echo $user_info['std_Lname']; ?></li>
            <li><strong>คณะ:</strong> <?php echo $user_info['std_faculty']; ?></li>
            <li><strong>สาขา:</strong> <?php echo $user_info['std_major']; ?></li>
            <li><strong>ที่อยู่:</strong> <?php echo $user_info['address']; ?></li>
            <li><strong>Email:</strong> <?php echo $user_info['std_email']; ?></li>
            <li><strong>เบอร์โทร:</strong> <?php echo $user_info['std_tel']; ?></li>
        </ul>
        <a href="?edit=true" class="btn btn-secondary">แก้ไขโปรไฟล์</a>
        <?php endif; ?>
    </div>
</body>

</html>