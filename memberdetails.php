<?php
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['employee_email']) && !isset($_SESSION['std_id'])) {
    header("Location: login.php");
    exit();
}

// Check the user's role (freelance or member)
$userRole = isset($_SESSION['employee_email']) ? 'freelance' : 'member';
?>
<!doctype html>
<html lang="en">

<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>TsuConnect</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
    <style>
    /* Additional CSS Styles */
    .job-details {
        background: linear-gradient(15deg, #369bd6 0%, #87a5c3 50%);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .job-details h1 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 24px;
        color: #333;
        margin-top: 0;
    }

    .job-details p {
        color: #555;
        margin: 10px 0;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
        margin-top: 10px;
        border-radius: 15px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        /* Add a subtle shadow */
        transition: transform 0.3s ease-in-out;
        /* Add a smooth hover effect */
    }

    /* Add a hover effect to scale images slightly on hover */
    .img-fluid:hover {
        transform: scale(1.05);
    }


    .freelance-details {
        margin-top: 20px;
        padding: 15px;
        background-color: #f5f5f5;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .freelance-details h2 {
        font-size: 20px;
        margin-top: 0;
    }

    .hire-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
    }

    .hire-button:hover {
        background-color: #0056b3;
    }

    /* Add CSS for the job title */
    .job-title {
        border-radius: 10px;
        font-size: 45px;
        /* Increase font size */
        font-weight: bold;
        /* Apply bold font weight */
        color: #FFFF;
        /* Change text color to a primary color */
        margin-top: 20px;
        /* Add spacing at the top */
        margin-bottom: 10px;
        /* Add spacing at the bottom */
        text-align: center;
        /* Center-align the title */
        text-transform: uppercase;
        /* Convert text to uppercase */
        letter-spacing: 1px;
        /* Add letter spacing */
        /* Add a subtle box shadow for depth */
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        background: linear-gradient(15deg, #369bd6 0%, #87a5c3 50%);

        /* You can add more styles as needed */
    }

    /* CSS for the "ดูโปรไฟล์" button */
    .view-profile-button {
        background-color: #28a745;
        /* Background color when not hovered */
        color: #fff;
        /* Text color */
        border: none;
        /* Remove button border */
        padding: 10px 20px;
        /* Adjust padding as needed */
        border-radius: 5px;
        /* Rounded corners */
        font-weight: 600;
        /* Font weight for bold text */
        cursor: pointer;
        /* Cursor style on hover */
        transition: background-color 0.3s ease-in-out;
        /* Smooth color transition */
    }

    .view-profile-button:hover {
        background-color: #218838;
        /* Background color on hover */
    }
    </style>
</head>

<body id="top">

    <main>

        <div>
            <?php
            include "membernav.php";
            ?>
        </div>

        <section class="explore-section section-padding" id="section_2">
            <div class="container">
                <div class="col-12 text-center">
                    <!-- <h2 class="mb-4">Browse Topics</h2> -->
                </div>
                <div class="row">
                <?php
include "db_connect.php";

// Check if a job_id is provided in the URL
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];

    // Create an SQL query to fetch job data based on the provided job_id
    $sql = "SELECT * FROM jobdata WHERE job_id = '$job_id'";

    // Execute the SQL query
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    // Check if job data is found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Start creating the "details.php" web page to display the job details
        echo '<div class="container">';
        echo '<h1 class="job-title">' . $row['job_title'] . '</h1>';
        echo '<div class="job-details">';
        echo '<img src="' . $row['image_path'] . '" alt="Job Image" class="img-fluid">';
        echo '<p>' . $row['job_description'] . '</p>';
        echo '<p>งบประมาณงาน: ' . $row['job_butget'] . '</p>';
        echo '<p>รหัสนิสิตฟรีแลนซ์: ' . $row['std_id'] . '</p>';
        echo '<a href="memfreepro.php?std_id=' . $row['std_id'] . '" class="view-profile-button" id="view-profile-button">ดูโปรไฟล์</a>';



        // Display a button to hire the freelancer
        echo '<button class="hire-button" id="hire-button">จ้างงาน</button>';

        // Display "freelance" contact information (hidden by default)
        echo '<div class="freelance-details" id="freelance-details" style="display:none;">';
        echo '<h2>ข้อมูลติดต่อ Freelance</h2>';

        // Fetch "freelance" data from the database
        $freelance_sql = "SELECT * FROM freelance WHERE std_id = '{$row['std_id']}'";
        $freelance_result = mysqli_query($connection, $freelance_sql);

        if ($freelance_result && mysqli_num_rows($freelance_result) > 0) {
            $freelance_row = mysqli_fetch_assoc($freelance_result);
            echo '<p>ชื่อ: ' . $freelance_row['std_Fname'] . ' ' . $freelance_row['std_Lname'] . '</p>';
            echo '<p>Email: ' . $freelance_row['std_email'] . '</p>';
            echo '<p>เบอร์โทร: ' . $freelance_row['std_tel'] . '</p>';
        }

        echo '</div>'; // Close "freelance-details" div
        echo '</div>'; // Close "job-details" div
        echo '</div>'; // Close "container" div
    } else {
        echo 'ไม่พบข้อมูลงานที่คุณค้นหา';
    }
} else {
    echo 'ไม่มีรหัสงานที่ระบุ';
}

// Close the database connection
mysqli_close($connection);
?>
   <script>
     // JavaScript to toggle the visibility of the "freelance-details" div
const hireButton = document.getElementById('hire-button');
const freelanceDetails = document.getElementById('freelance-details');

hireButton.addEventListener('click', function() {
    if (freelanceDetails.style.display === 'none') {
        freelanceDetails.style.display = 'block';

        // Send an AJAX request to insert job data into the database
        insertJobData();
    } else {
        freelanceDetails.style.display = 'none';
    }
});

// Function to insert job data into the database using AJAX
function insertJobData() {
    // Get job data from the page
    const jobTitle = '<?php echo $row['job_title']; ?>';
    const jobCategory = '<?php echo $row['job_category']; ?>';
    const jobDescription = '<?php echo $row['job_description']; ?>';
    const jobBudget = '<?php echo $row['job_butget']; ?>';
    const stdId = '<?php echo $row['std_id']; ?>';

    // Retrieve employee_id from PHP session
    const employeeId = '<?php echo $_SESSION['employee_id']; ?>';

    // Create a data object to send in the POST request
    const data = {
        job_title: jobTitle,
        job_category: jobCategory,
        job_description: jobDescription,
        job_budget: jobBudget,
        std_id: stdId,
        employee_id: employeeId // Add employee_id to the data object
    };

    // Send a POST request to insert_job_data.php
    fetch('insert_job_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(result => {
        if (result === 'success') {
            alert('ข้อมูลงานถูกจัดเก็บเรียบร้อยแล้ว');
        } else {
            alert('เกิดข้อผิดพลาดในการจัดเก็บข้อมูลงาน');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

    </script>
</main>

    </main>
</body>
</html>