<?php
// Establish connection to your database
$db_host = 'localhost';  // Your host
$db_user = 'root';   // Your database username
$db_pass = '';   // Your database password
$db_name = 'reps_db';   // Your database name

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch real estate data from the database
$sql = "SELECT * FROM `real_estate_list`";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Real Estates</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Real Estates</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Type</th>
            <th>Status</th>
            <th>Thumbnail</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                if($row['status'] == 0)
                {
                $value = "not Approved";
                }
                elseif($row['status'] == 1)
                {
                    $value = "Approved";
                }

                echo "<tr>";
                echo "<td>{$row['code']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>Residential</td>";
                echo "<td>{$value}</td>";
                echo "<td>";

                // Check if thumbnail_path exists and is not empty
                if (isset($row['thumbnail_path']) && !empty($row['thumbnail_path'])) {
                    echo "<img src='{$row['thumbnail_path']}' width='100' height='100' alt='Thumbnail'>";
                } else {
                    echo "Thumbnail not available";
                }

                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No real estate data found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
