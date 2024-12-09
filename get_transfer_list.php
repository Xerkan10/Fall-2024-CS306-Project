<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

// Fetch the transfer list from the database
$sql = "SELECT transfer_id, team_name, player_name, transfer_amount, agent_name, offer_date FROM transfer_list";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

echo "<h1>Transfer List</h1>";

if ($result->num_rows > 0) {
    echo "<form action='submit_transfer_offer.php' method='POST'>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Select</th>
            <th>Transfer ID</th>
            <th>Team Name</th>
            <th>Player Name</th>
            <th>Transfer Amount</th>
            <th>Agent Name</th>
            <th>Offer Date</th>
            <th>Offer Salary ($)</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>
            <input type='radio' name='transfer_id' value='{$row['transfer_id']}' required>
            <input type='hidden' name='transfer_offer[{$row['transfer_id']}]' value='{$row['transfer_amount']}'>
        </td>
        <td>{$row['transfer_id']}</td>
        <td>{$row['team_name']}</td>
        <td>{$row['player_name']}</td>
        <td>{$row['transfer_amount']}</td>
        <td>{$row['agent_name']}</td>
        <td>{$row['offer_date']}</td>
        <td><input type='number' name='salary_offer[{$row['transfer_id']}]' placeholder='Enter Salary'></td>
      </tr>";

    }

    echo "</table>";
    echo "<label for='manager_id'>Manager ID:</label>";
    echo "<input type='number' id='manager_id' name='manager_id' required>";
    echo "<button type='submit'>Submit Offer</button>";
    echo "</form>";
} else {
    echo "<p>No players are currently listed for transfer.</p>";
}

$conn->close();
?>
