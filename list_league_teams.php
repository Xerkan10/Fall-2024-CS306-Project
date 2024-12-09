<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

// Check if league_name is provided
$league_name = isset($_POST['league_name']) ? trim($conn->real_escape_string($_POST['league_name'])) : '';

// Determine the query based on the league name
if ($league_name === '') {
    // If league_name is empty, fetch all teams
    $sql = "SELECT * FROM TEAM";
} else {
    // If league_name is provided, fetch teams from the specified league
    $sql = "SELECT TEAM.team_name, TEAM.team_player_count, TEAM.league_name
            FROM TEAM
            JOIN LEAGUE ON TEAM.league_name = LEAGUE.league_name
            WHERE TEAM.league_name = '$league_name'";
}

// Execute the query
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Display results
echo "<h1>Teams in League: " . ($league_name === '' ? 'All Leagues' : $league_name) . "</h1>";
if ($result->num_rows > 0) {
    // Display results in an HTML table
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Team Name</th>
            <th>Player Count</th>
            <th>League Name</th>
          </tr>";

    // Fetch rows and display in the table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['team_name']}</td>
                <td>{$row['team_player_count']}</td>
                <td>{$row['league_name']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    // No records found
    echo "<p>No teams found for the specified league.</p>";
}

// Close the database connection
$conn->close();
?>
