$(document).ready(function(){
    <?php
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

    // Get data from the form
    $std_id = $_POST['std_id'];
    $std_Fname = $_POST['std_Fname'];
    $std_Lname = $_POST['std_Lname'];
    $std_faculty = $_POST['std_faculty'];
    $std_major = $_POST['std_major'];
    $address = $_POST['address'];
    $std_tel = $_POST['std_tel'];

    // Prepare the SQL query to insert data into the 'freelance' table
    $query = "INSERT INTO `freelance` (`std_id`, `std_Fname`, `std_Lname`, `std_faculty`, `std_major`, `address`, `std_tel`) 
              VALUES ('$std_id', '$std_Fname', '$std_Lname', '$std_faculty', '$std_major', '$address', '$std_tel')";

    // Execute the query
    if ($connection->query($query) === TRUE) {
        header("Location: buttons.php");// Redirect to button.php on success
    } else {
        echo "console.error('Error: " . $query . "', '" . $connection->error . "');";
    }

    // Close the database connection
    $connection->close();
    ?>
});
