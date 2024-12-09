<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

// Query to fetch all leagues
$sql = "SELECT * FROM LEAGUE";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Handle query failure
}

echo "<h1>All Leagues in the Database</h1>";

// Check if there are leagues in the table
if ($result->num_rows > 0) {
    // Display leagues in an HTML table
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Duration</th>
            <th>Team Number</th>
            <th>League Name</th>
            <th>Federation Name</th>
          </tr>";

    // Fetch and display each row in the table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['duration']}</td>
                <td>{$row['team_number']}</td>
                <td>{$row['league_name']}</td>
                <td>{$row['fed_name']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No leagues found in the database.</p>";
}

// Close the database connection
$conn->close();
?>

