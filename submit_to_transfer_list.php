<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

if (!empty($_POST['player_id'])) { 
    // Retrieve the selected player ID
    $player_id = $conn->real_escape_string($_POST['player_id']); 
    
    // Retrieve the transfer amount corresponding to the selected player
    $transfer_amount_dollars = $_POST['transfer_amount_dollars'][$player_id] ?? 0;

    if ($transfer_amount_dollars > 0) {
        // Query to fetch player details
        $sql = "SELECT player_name, team_name, AGENT.agent_name 
                FROM PLAYER 
                JOIN AGENT ON PLAYER.agent_id = AGENT.agent_id 
                WHERE player_id = '$player_id'";
        
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $player_name = $row['player_name'];
            $team_name = $row['team_name'];
            $agent_name = $row['agent_name'];

            // Call the stored procedure to add the transfer offer
            $sql2 = "CALL AddToTransferList('$team_name', '$player_name', $transfer_amount_dollars, '$agent_name')";
            $result2 = mysqli_query($conn, $sql2);

            if (!$result2) {
                echo "<p style='color: red;'>Error executing procedure: " . mysqli_error($conn) . "</p>";
            } else {
                echo "<p style='color: green;'>Procedure executed successfully! $player_name has been added to the transfer list with a transfer amount of $$transfer_amount_dollars.</p>";
            }
        } else {
            echo "<p style='color: red;'>Player not found in the database.</p>";
        }
    } else {
        echo "<p style='color: red;'>Please provide a valid transfer amount.</p>";
    }
    $conn->close(); // Close the database connection
} else {
    echo "<p style='color: red;'>No player selected. Please select a player.</p>";
}
?>
