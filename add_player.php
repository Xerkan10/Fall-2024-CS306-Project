<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
include 'config.php'; // Replace 'config.php' with your actual database configuration file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $player_id = $conn->real_escape_string($_POST['player_id']);
    $player_name = $conn->real_escape_string($_POST['player_name']);
    $player_salary = $conn->real_escape_string($_POST['player_salary']);
    $player_age = $conn->real_escape_string($_POST['player_age']);
    $player_position = strtolower($conn->real_escape_string($_POST['player_position']));
    $prefered_foot = strtolower($conn->real_escape_string($_POST['prefered_foot']));
    $team_name = $conn->real_escape_string($_POST['team_name']);
    $agent_id = $conn->real_escape_string($_POST['agent_id']);

    // Validate required fields
    if (empty($player_id) || empty($player_name) || empty($player_salary) || empty($player_age) || empty($prefered_foot) || empty($team_name) || empty($agent_id)) {
        echo "<p style='color: red;'>Please fill in all required fields.</p>";
        exit;
    }

    // Check if player_id or player_name already exists
    $player_check_query = "SELECT * FROM PLAYER WHERE player_id = '$player_id' OR player_name = '$player_name'";
    $player_check_result = mysqli_query($conn, $player_check_query);
    if ($player_check_result && $player_check_result->num_rows > 0) {
        echo "<p style='color: red;'>Error: Player ID or Player Name already exists in the database.</p>";
        exit;
    }

    // Check if team_name exists in the TEAM table
    $team_check_query = "SELECT * FROM TEAM WHERE team_name = '$team_name'";
    $team_check_result = mysqli_query($conn, $team_check_query);
    if ($team_check_result && $team_check_result->num_rows === 0) {
        echo "<p style='color: red;'>Error: The team '$team_name' does not exist in the database. Please provide a valid team name.</p>";
        exit;
    }

    // Validate player_position
    $valid_positions = ['midfielder', 'forward', 'defender', 'goalkeeper'];
    if (!in_array($player_position, $valid_positions)) {
        echo "<p style='color: red;'>Error: Invalid player position. Valid positions are: Midfielder, Forward, Defender, Goalkeeper.</p>";
        exit;
    }

    // Validate prefered_foot
    $valid_foots = ['right', 'left'];
    if (!in_array($prefered_foot, $valid_foots)) {
        echo "<p style='color: red;'>Error: Invalid preferred foot. Valid options are: Right, Left.</p>";
        exit;
    }

    // Insert the new player
    $sql = "INSERT INTO PLAYER (player_id, player_name, player_salary, player_age, player_position, prefered_foot, team_name, agent_id)
            VALUES ('$player_id', '$player_name', '$player_salary', '$player_age', '$player_position', '$prefered_foot', '$team_name', '$agent_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green;'>Player added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Fetch and display the PLAYER table
$sql = "SELECT * FROM PLAYER";
$result = mysqli_query($conn, $sql);

if ($result && $result->num_rows > 0) {
    echo "<h3>PLAYER Table</h3>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Player ID</th>
            <th>Player Name</th>
            <th>Player Salary</th>
            <th>Player Age</th>
            <th>Player Position</th>
            <th>Preferred Foot</th>
            <th>Team Name</th>
            <th>Agent ID</th>
          </tr>";
    
    // Display rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['player_id']}</td>
                <td>{$row['player_name']}</td>
                <td>{$row['player_salary']}</td>
                <td>{$row['player_age']}</td>
                <td>{$row['player_position']}</td>
                <td>{$row['prefered_foot']}</td>
                <td>{$row['team_name']}</td>
                <td>{$row['agent_id']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records found in the PLAYER table.</p>";
}

// Close the database connection
$conn->close();
?>
