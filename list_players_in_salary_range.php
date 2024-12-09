<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve user input
    $min_salary = intval($_POST['min_salary']);
    $max_salary = intval($_POST['max_salary']);

    // Validate inputs
    if ($min_salary <= 0 || $max_salary <= 0 || $min_salary > $max_salary) {
        echo "<p style='color: red;'>Invalid salary range. Please enter valid numbers and ensure the lower bound is less than or equal to the upper bound.</p>";
        exit;
    }

    // Query to fetch players within the salary range
    $sql = "SELECT player_id, player_name, player_salary, team_name, player_position, prefered_foot 
            FROM PLAYER 
            WHERE player_salary BETWEEN $min_salary AND $max_salary";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    // Display results
    echo "<h1>Players with Salary Between $$min_salary and $$max_salary</h1>";
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>Player ID</th>
                <th>Player Name</th>
                <th>Player Salary ($)</th>
                <th>Team Name</th>
                <th>Player Position</th>
                <th>Preferred Foot</th>
              </tr>";

        // Loop through and display each player
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['player_id']}</td>
                    <td>{$row['player_name']}</td>
                    <td>{$row['player_salary']}</td>
                    <td>{$row['team_name']}</td>
                    <td>{$row['player_position']}</td>
                    <td>{$row['prefered_foot']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No players found within the specified salary range.</p>";
    }

    $conn->close(); // Close database connection
}
?>