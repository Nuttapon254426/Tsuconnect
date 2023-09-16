<?php
session_start();

// เช็คว่าผู้ใช้ล็อกอินเข้าสู่ระบบหรือไม่
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['std_id'])) {
    // ถ้าไม่ได้ล็อกอิน ส่งผู้ใช้กลับไปยังหน้า login
    header("Location: login.php");
    exit();
}

// // ใช้ค่า employee_id หรือ std_id ตามความเหมาะสมในหน้านี้
// if (isset($_SESSION['employee_id'])) {
//     $employee_id = $_SESSION['employee_id'];
//     // ใช้ค่า employee_id ตามที่คุณต้องการในหน้านี้
// }

// if (isset($_SESSION['std_id'])) {
//     $std_id = $_SESSION['std_id'];
//     // ใช้ค่า std_id ตามที่คุณต้องการในหน้านี้
// }

?>
<?php
// Start a PHP session (if not already started)
session_start();

$hostname = "localhost";
$username = "root";
$password = "";
$database = "tsufreelance";

// Create a database connection
$connection = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
// Function to validate and sanitize user input
function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $job_title = sanitizeInput($_POST["job_title"]);
    $job_description = sanitizeInput($_POST["job_description"]);
    $job_butget = floatval($_POST["job_butget"]); // Convert to float
    $job_category = sanitizeInput($_POST["job_category"]);

    // Check if std_id is available in the session
    if (isset($_SESSION["std_id"])) {
        $std_id = $_SESSION["std_id"];

        // Handle image upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        if (getimagesize($_FILES["image"]["tmp_name"]) === false) {
            echo "File is not an image.";
        } else if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        } else if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Prepare and execute an INSERT statement
            $sql = "INSERT INTO jobdata (job_title, job_description, job_butget, job_category, image_path, std_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            if ($stmt === false) {
                die("Error preparing the SQL statement: " . $connection->error);
            }

            $stmt->bind_param("ssdssi", $job_title, $job_description, $job_butget, $job_category, $target_file, $std_id);
            if ($stmt->execute()) {
                echo "Data inserted successfully.";
                // Redirect to Board.php
                header("Location: Board.php");
                exit(); // Ensure that no further code is executed after the redirect
            } else {
                echo "Error inserting data: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Session std_id not set. Please login and try again.";
    }
}

// Close the database connection
$connection->close();
?>

