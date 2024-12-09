<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

if (!empty($_POST['team_name'])) {
    $team_name = $conn->real_escape_string($_POST['team_name']);
    $year = intval($_POST['year']);

    $sql = "SELECT *
FROM DEALS_DONE
WHERE new_team = '$team_name' AND deal_year = '$year';";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    echo "<h1>Transfers for Team: $team_name in $year</h1>";
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>Previous Team</th>
                <th>New Team</th>
                <th>Player Name</th>
                <th>Transfer Amount ($)</th>
                <th>Salary Amount ($)</th>
                <th>Deal Year</th>
              </tr>";
    
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
    
        echo "</table>";
    } else {
        echo "No transfers found for team $team_name in $year.";
    }
    
    $conn->close();
}
?>