<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transfer_id = $conn->real_escape_string($_POST['transfer_id']);
    $manager_id = $conn->real_escape_string($_POST['manager_id']);
    $salary_offer = isset($_POST['salary_offer'][$transfer_id]) ? intval($_POST['salary_offer'][$transfer_id]) : 0;
    $transfer_offer = isset($_POST['transfer_offer'][$transfer_id]) ? intval($_POST['transfer_offer'][$transfer_id]) : 0;

    // Validate required fields
    if (empty($transfer_id) || empty($manager_id) || empty($salary_offer) || empty($transfer_offer)) {
        echo "<p style='color: red;'>All fields are required. Please try again.</p>";
        exit;
    }

    // Fetch transfer details for the selected player
    $sql_transfer = "SELECT team_name, player_name, agent_name FROM transfer_list WHERE transfer_id = '$transfer_id'";
    $result_transfer = mysqli_query($conn, $sql_transfer);

    if ($result_transfer && $result_transfer->num_rows > 0) {
        $transfer_row = $result_transfer->fetch_assoc();
        $player_name = $transfer_row['player_name'];
        $agent_name = $transfer_row['agent_name'];
        $team_name = $transfer_row['team_name'];

        // Fetch manager's team name
        $sql_manager_team = "SELECT team_name FROM MANAGER WHERE manager_id = '$manager_id'";
        $result_manager_team = mysqli_query($conn, $sql_manager_team);

        if ($result_manager_team && $result_manager_team->num_rows > 0) {
            $manager_team_row = $result_manager_team->fetch_assoc();
            $manager_team_name = $manager_team_row['team_name'];

            // Check if the player is in the manager's own team
            if ($team_name === $manager_team_name) {
                echo "<p style='color: red;'>Error: You cannot make an offer to a player from your own team.</p>";
                exit;
            }

            // Check if an offer already exists for this player by the same manager
            $sql_check_offer = "SELECT * FROM TRANSFER_OFFER WHERE player_name = '$player_name' AND manager_name = 
                (SELECT EMPLOYEE.employee_name 
                 FROM MANAGER 
                 JOIN EMPLOYEE ON MANAGER.employee_id = EMPLOYEE.employee_id 
                 WHERE manager_id = '$manager_id')";

            $result_check_offer = mysqli_query($conn, $sql_check_offer);

            if ($result_check_offer && $result_check_offer->num_rows > 0) {
                echo "<p style='color: red;'>Error: You have already made an offer for this player.</p>";
                exit;
            }

            // Fetch manager name using manager_id
            $sql_manager = "SELECT EMPLOYEE.employee_name 
                            FROM MANAGER 
                            JOIN EMPLOYEE ON MANAGER.employee_id = EMPLOYEE.employee_id 
                            WHERE manager_id = '$manager_id'";
            $result_manager = mysqli_query($conn, $sql_manager);

            if ($result_manager && $result_manager->num_rows > 0) {
                $manager_row = $result_manager->fetch_assoc();
                $manager_name = $manager_row['employee_name'];

                if (!is_numeric($_POST['salary_offer'][$transfer_id]) || !is_numeric($_POST['transfer_offer'][$transfer_id])) {
                    die("Invalid input: Salary or transfer offer must be numeric values.");
                }

                // Insert the offer into the transfer_offer table using CURRENT_TIME for offer_date
                $sql_insert = "INSERT INTO TRANSFER_OFFER (player_name, agent_name, manager_name, offer_date, salary_offer, transfer_offer)
                VALUES ('$player_name', '$agent_name', '$manager_name', CURRENT_TIME, $salary_offer, $transfer_offer)"; 

                if (mysqli_query($conn, $sql_insert)) {
                    echo "<p style='color: green;'>Offer submitted successfully for player '$player_name'!</p>";
                } else {
                    echo "<p style='color: red;'>Error inserting offer: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<p style='color: red;'>Error: Manager details not found. Please try again.</p>";
            }
        } else {
            echo "<p style='color: red;'>Error: Manager's team details not found. Please try again.</p>";
        }
    } else {
        echo "<p style='color: red;'>Error: Transfer details not found. Please try again.</p>";
    }
}

$conn->close();
?>