<?php
include "membernav.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .item {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .rating {
            font-size: 24px;
            margin-top: 10px;
        }

        .star-container {
            display: inline-block;
            position: relative;
        }

        .star {
            cursor: pointer;
            color: #ccc;
            font-size: 30px;
            transition: color 0.3s ease;
        }

        .star.checked {
            color: orange;
        }

        .star:hover {
            transform: scale(1.2); /* Add a hover effect */
        }
    </style>
</head>
<body>
<h1>Rate Items</h1>

<?php
include "db_connect.php";
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch items from the database with epm_status equal to "ส่งมอบงานแล้ว"
$employee_id = $_SESSION['employee_id']; // Assuming you have this available
$sql = "SELECT `epm_id`, `epm_title`, `epm_description`, `epm_rating` 
        FROM `epminfo` 
        WHERE `employee_id` = '$employee_id' 
        AND `epm_status` = 'ส่งมอบงานแล้ว'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $itemId = $row["epm_id"];
        $title = $row["epm_title"];
        $description = $row["epm_description"];
        $rating = $row["epm_rating"];

        echo "<div class='item'>";
        echo "<h2>$title</h2>";
        echo "<p>$description</p>";
        echo "<div class='rating'>";
        for ($i = 1; $i <= 5; $i++) {
            $checked = ($i <= $rating) ? 'checked' : '';
            echo "<span class='star $checked' data-rating='$i' data-item-id='$itemId'>&#9733;</span>";
        }
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No items found in the database.";
}

$connection->close();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function () {
    $(".star").click(function () {
        var newRating = $(this).data("rating");
        var itemId = $(this).data("item-id");

        // Send an AJAX request to update the rating in the database
        $.ajax({
            type: "POST",
            url: "update_rating.php",
            data: { itemId: itemId, rating: newRating },
            success: function (response) {
                // Update the UI to reflect the new rating
                $(".star[data-item-id='" + itemId + "']").removeClass("checked");
                $(".star[data-item-id='" + itemId + "']").each(function () {
                    if ($(this).data("rating") <= newRating) {
                        $(this).addClass("checked");
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>
