<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $team_name = $conn->real_escape_string($_POST['team_name']);
    $league_name = $conn->real_escape_string($_POST['league_name']);
    $city = $conn->real_escape_string($_POST['city']);

    // Check if the team name already exists
    $team_check_query = "SELECT * FROM TEAM WHERE team_name = '$team_name'";
    $team_check_result = mysqli_query($conn, $team_check_query);

    if ($team_check_result && $team_check_result->num_rows > 0) {
        echo "<p style='color: red;'>Error: A team with the name '$team_name' already exists in the database.</p>";
    } else {
        // Check if the league name is valid
        $league_check_query = "SELECT * FROM LEAGUE WHERE league_name = '$league_name'";
        $league_check_result = mysqli_query($conn, $league_check_query);

        if ($league_check_result && $league_check_result->num_rows > 0) {
            // Insert the new team if validation passes
            $sql = "INSERT INTO TEAM (team_name, league_name, city, team_player_count)
                    VALUES ('$team_name', '$league_name', '$city', 0)";

            if (mysqli_query($conn, $sql)) {
                echo "<p style='color: green;'>Team '$team_name' added successfully!</p>";
            } else {
                echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Error: The league '$league_name' does not exist in the database. Please provide a valid league name.</p>";
        }
    }
}

// Fetch all teams from the TEAM table
$sql = "SELECT * FROM TEAM";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Debugging query errors
}

echo "<h1>All Teams</h1>";

// Display all teams in a table
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Team Name</th>
            <th>League Name</th>
            <th>City</th>
            <th>Team Player Count</th>
          </tr>";

    // Fetch rows and display in the table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['team_name']}</td>
                <td>{$row['league_name']}</td>
                <td>{$row['city']}</td>
                <td>{$row['team_player_count']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No teams found in the database.</p>";
}

// Close the database connection
$conn->close();
?>
