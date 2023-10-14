<?php
              include "membernav.php"; 
            ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}
// Check if the user is logged in
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['employee_id'])) {
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

$user_id = $_SESSION['employee_id'];

// Fetch user information from the database based on user_id
$user_info = [];
if (isset($user_id)) {
    $sql = "SELECT * FROM employee WHERE employee_id = $user_id";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
    }
}

// Handle form submission for profile updates
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST['new_name'];
    $new_telnumber =$_POST['new_telnumber'];
    $new_email = $_POST['new_email'];

    $update_sql = "UPDATE employee SET employee_name='$new_name',telnumber='$new_telnumber', employee_email='$new_email' WHERE employee_id=$user_id";

    if ($connection->query($update_sql) === TRUE) {
        // Update successful, refresh user info
        $sql = "SELECT * FROM employee WHERE employee_id = $user_id";
        $result = $connection->query($sql);

        if ($result && $result->num_rows > 0) {
            $user_info = $result->fetch_assoc();
        }

        // Optionally, you could display a success message here
    } else {
        echo "Error updating record: " . $connection->error;
    }
}
// Handle the uploaded profile image
if (isset($_FILES["profile_image"]) && !empty($_FILES["profile_image"]["tmp_name"])) {
    $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];
    $uploaded_file_mime_type = mime_content_type($_FILES["profile_image"]["tmp_name"]);

    if (in_array($uploaded_file_mime_type, $allowed_mime_types)) {
        // Move the uploaded file to a directory on your server
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            // Update the user's profile image in the database
            $update_image_sql = "UPDATE employee SET profile_image='$target_file' WHERE employee_id=$user_id";
            if ($connection->query($update_image_sql) !== TRUE) {
                echo "Error updating profile image: " . $connection->error;
            }
        } else {
            echo "Error uploading image: " . $_FILES["profile_image"]["error"];
        }
    } else {
        echo "Error: The uploaded file is not a valid image file.";
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Member Profile | Tsu Freelance Connect</title>

    <!-- Add Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/templatemo-topic-listing.css" rel="stylesheet">

    <!-- Add custom CSS styles here -->
    <style>
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        padding-top: 40px;
    }

    .card {
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
        font-weight: 600;
        margin-bottom: 20px;
    }

    label {
        font-weight: 600;
    }

    .form-control {
        margin-bottom: 15px;
    }
    </style>
</head>

<body>
    <?php include "membernav.php"; ?>

    <div class="container">
        <div class="card">
            <h1>โปรไฟล์สมาชิก</h1>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <div class="form-group">
        <label for="profile_image">เลือกรูปโปรไฟล์:</label>
        <input type="file" class="form-control-file" id="profile_image" name="profile_image">
    </div>
    
    <!-- Display the current profile image -->
    <div class="form-group">
        <label>รูปโปรไฟล์ปัจจุบัน:</label>
        <?php
        if (!empty($user_info['profile_image'])) {
            echo '<img src="' . $user_info['profile_image'] . '" alt="Profile Image" class="img-thumbnail" style="max-width: 200px;">';
        } else {
            echo 'No profile image available.';
        }
        ?>
    </div>
    
    <div class="form-group">
        <label for="new_name">ชื่อ-สกุล:</label>
        <input type="text" class="form-control" id="new_name" name="new_name" value="<?php echo $user_info['employee_name']; ?>">
    </div>
    <div class="form-group">
        <label for="new_telnumber">เบอร์โทรศัพท์:</label>
        <input type="text" class="form-control" id="new_telnumber" name="new_telnumber" value="<?php echo $user_info['telnumber']; ?>">
    </div>

    <div class="form-group">
        <label for="new_email">อีเมลล์:</label>
        <input type="email" class="form-control" id="new_email" name="new_email" value="<?php echo $user_info['employee_email']; ?>">
    </div>

    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>