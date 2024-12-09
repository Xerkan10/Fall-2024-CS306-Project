<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

// Fetch all rows from the DEALS_DONE table
$sql = "SELECT * FROM DEALS_DONE";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching done deals: " . mysqli_error($conn));
}

echo "<h1>List of Done Deals</h1>";

if ($result->num_rows > 0) {
    // Start the table
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
        <th>Previous Team</th>
        <th>New Team</th>
        <th>Player Name</th>
        <th>Transfer Amount ($)</th>
        <th>Salary Amount ($)</th>
        <th>Deal Year</th>
      </tr>";

// Loop through each row and display the data
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['previous_team']}</td>
            <td>{$row['new_team']}</td>
            <td>{$row['player_name']}</td>
            <td>{$row['transfer_amount']}</td>
            <td>{$row['salary_amount']}</td>
            <td>{$row['deal_year']}</td>
          </tr>";
}


    // End the table
    echo "</table>";
} else {
    echo "<p>No deals have been finalized yet.</p>";
}

// Close the database connection
$conn->close();
?>
