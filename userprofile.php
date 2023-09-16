<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['std_id'])) {
    header("Location: login.php");
    exit();
}

// Get user information from the session
$std_id = $_SESSION['std_id'];
$std_name = $_SESSION['std_name'];
$std_email = $_SESSION['std_email'];
$std_tel = $_SESSION['std_tel'];

// Handle form submission for updating user information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user-submitted data
    $new_email = $_POST['new_email'];
    $new_tel = $_POST['new_tel'];

    // Perform validation and update user information in the database
    // You should implement database update logic here

    // Update user information in the session
    $_SESSION['std_email'] = $new_email;
    $_SESSION['std_tel'] = $new_tel;

    // Redirect to the user profile page with a success message
    header("Location: userprofile.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <h1>User Profile</h1>

    <?php
    // Display a success message if the user information was updated
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<p style="color: green;">Profile updated successfully!</p>';
    }
    ?>

    <form method="post">
        <label for="std_id">Student ID:</label>
        <input type="text" id="std_id" name="std_id" value="<?php echo $std_id; ?>" readonly><br>

        <label for="std_name">Name:</label>
        <input type="text" id="std_name" name="std_name" value="<?php echo $std_name; ?>" readonly><br>

        <label for="std_email">Email:</label>
        <input type="email" id="std_email" name="new_email" value="<?php echo $std_email; ?>"><br>

        <label for="std_tel">Telephone:</label>
        <input type="tel" id="std_tel" name="new_tel" value="<?php echo $std_tel; ?>"><br>

        <input type="submit" value="Save Changes">
    </form>

    <!-- Add other profile information as needed -->
</body>
</html>
