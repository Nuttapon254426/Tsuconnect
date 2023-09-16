<!DOCTYPE html>
<html>

<head>
    <title>Student Information</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>ข้อมูลนิสิตฟรีแลนซ์</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสนิสิต</th>
                    <th>ชื่อของนิสิต</th>
                    <th>คณะของนิสิต</th>
                    <th>สาขาวิชาของนิสิต</th>
                    <th>ที่อยู่ของนิสิต </th>
                    <th>อีเมล์ของนิสิต</th>
                    <th>รหัสผ่านของนิสิต</th>
                    <th>เบอร์โทรของนิสิต</th>
                    <th>สถานะของนิสิต</th>
                    <th>วัน/เวลาที่สมัคร</th>
                    <th>เพิ่ม/ลบ สถานะ</th> <!-- Add a new column for the action button -->
                </tr>
            </thead>
            <tbody>
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

                // Query to select all data from the 'freelance' table
                $query = "SELECT * FROM `freelance`ORDER BY user_level, `date` deSC;";

                // Execute the query
                $result = $connection->query($query);

                // Check if the query was successful
                if ($result) {
                    // Fetch and display the results in a table row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['std_id']}</td>";
                        echo "<td>{$row['std_Fname']} {$row['std_Lname']}</td>";
                        echo "<td>{$row['std_faculty']}</td>";
                        echo "<td>{$row['std_major']}</td>";
                        echo "<td>{$row['address']}</td>";
                        echo "<td>{$row['std_email']}</td>";
                        echo "<td>{$row['std_pass']}</td>";
                        echo "<td>{$row['std_tel']}</td>";
                        echo "<td>{$row['user_level']}</td>";
                        echo "<td>{$row['date']}</td>";

                        // Check if user_level is not 'freelance', then show the add button
                        // Check if user_level is 'freelance', then show the delete button
if ($row['user_level'] === 'freelance') {
    echo '<td>
          <form method="post" action="delete_freelance.php"> <!-- Change the action to your delete_freelance.php file -->
            <input type="hidden" name="student_id" value="' . $row['std_id'] . '">
            <button type="submit" name="delete_freelance" class="btn btn-danger">Delete Freelance</button>
          </form>
        </td>';
} else {
    // Show the Add Freelance button if user_level is not 'freelance'
    echo '<td>
          <form method="post" action="add_freelance.php"> <!-- Change the action to your add_freelance.php file -->
            <input type="hidden" name="student_id" value="' . $row['std_id'] . '">
            <button type="submit" name="add_freelance" class="btn btn-success">Add Freelance</button>
          </form>
        </td>';
}


                        echo "</tr>";
                    }

                    // Close the result set
                    $result->close();
                } else {
                    echo "Error executing the query: " . $connection->error;
                }

                // Close the database connection
                $connection->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>