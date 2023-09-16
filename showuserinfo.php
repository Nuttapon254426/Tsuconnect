<?php
// Include the db_connect.php file (adjust the path as needed)
include('db_connect.php');

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// SQL query to retrieve users where user_level is not 'admin'
$sql = "SELECT * FROM employee WHERE user_level != 'admin'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead class='thead-dark'>";
    echo "<tr><th>Employee ID</th><th>Employee Name</th><th>Sex</th><th>Telephone Number</th><th>Location</th><th>Employee Email</th><th>User Level</th><th>date_time</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    
    // Output the user information as table rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['employee_id'] . "</td>";
        echo "<td>" . $row['employee_name'] . "</td>";
        echo "<td>" . $row['sex'] . "</td>";
        echo "<td>" . $row['telnumber'] . "</td>";
        echo "<td>" . $row['location'] . "</td>";
        echo "<td>" . $row['employee_email'] . "</td>";
        echo "<td>" . $row['user_level'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "No users found with user_level other than 'admin'.";
}

$connection->close();
?>
