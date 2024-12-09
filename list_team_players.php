<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

// Check if team_name is set in POST request
$team_name = isset($_POST['team_name']) ? trim($conn->real_escape_string($_POST['team_name'])) : '';

// Determine the query based on the input
if ($team_name === '') {
    // If no input is provided, fetch all players
    $sql = "SELECT player_id, player_name, player_salary, transfer_cost, player_position, prefered_foot, team_name FROM PLAYER";
    echo "<h1>All Players</h1>";
} else {
    // Fetch players from the specified team
    $sql = "SELECT player_id, player_name, player_salary, transfer_cost, player_position, prefered_foot, team_name FROM PLAYER WHERE team_name = '$team_name'";
    echo "<h1>Players in Team: $team_name</h1>";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Debugging query errors
}

if ($result->num_rows > 0) {
    // Display players in a table
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Player ID</th>
            <th>Player Name</th>
            <th>Player Salary</th>
            <th>Transfer Cost</th>
            <th>Player Position</th>
            <th>Preferred Foot</th>
            <th>Team Name</th>
          </tr>";

    // Fetch rows and display in the table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['player_id']}</td>
                <td>{$row['player_name']}</td>
                <td>{$row['player_salary']}</td>
                <td>{$row['transfer_cost']}</td>
                <td>{$row['player_position']}</td>
                <td>{$row['prefered_foot']}</td>
                <td>{$row['team_name']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    if ($team_name === '') {
        echo "<p>No players found in the database.</p>";
    } else {
        echo "<p>No players found in the team $team_name.</p>";
    }
}

$conn->close(); // Close database connection
?>
