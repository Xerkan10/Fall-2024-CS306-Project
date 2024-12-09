<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

// Initialize variables for HTML rendering
$players = [];
$error_message = "";

// Check if league name is provided
if (!empty($_POST['manager_id'])) {
    $manager_id = $conn->real_escape_string($_POST['manager_id']);

    // Simulate a logged-in manager ID (replace with session or actual logic)

    // Query to fetch players for the manager in the specified league
    $sql = "SELECT 
    PLAYER.player_id, 
    PLAYER.player_name, 
    PLAYER.player_position, 
    PLAYER.team_name, 
    PLAYER.player_salary
FROM 
    PLAYER
JOIN 
    MANAGER ON PLAYER.team_name = MANAGER.team_name
WHERE 
    MANAGER.manager_id = '$manager_id';";

    
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $error_message = "Error fetching players: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $players[] = $row;
        }
    } else {
        $error_message = "No players found for manager ID: $manager_id";
    }
}

// Pass data to the HTML file
include 'add_to_transfer_viewing.php';
?>
