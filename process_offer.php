<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offer_id = $conn->real_escape_string($_POST['offer_id']);
    $player_name = $conn->real_escape_string($_POST['player_name']);
    $manager_name = $conn->real_escape_string($_POST['manager_name']); // Manager ID to fetch team_name
    $transfer_offer = intval($_POST['transfer_offer']);
    $salary_offer = intval($_POST['salary_offer']);
    $action = $_POST['action']; // 'accept' or 'reject'

    if ($action === 'accept') {
        // Fetch player's current team
        $sql_team = "SELECT team_name FROM PLAYER WHERE player_name = '$player_name'";
        $result_team = mysqli_query($conn, $sql_team);

        if ($result_team && $result_team->num_rows > 0) {
            $row_team = $result_team->fetch_assoc();
            $previous_team = $row_team['team_name'];

            // Fetch the new team for the manager
            $sql_manager_team = "SELECT team_name FROM MANAGER JOIN EMPLOYEE ON EMPLOYEE.employee_id=MANAGER.employee_id WHERE employee_name = '$manager_name'";
            $result_manager_team = mysqli_query($conn, $sql_manager_team);

            if ($result_manager_team && $result_manager_team->num_rows > 0) {
                $manager_team_row = $result_manager_team->fetch_assoc();
                $new_team = $manager_team_row['team_name'];

                // Insert the deal into the done_deal table
                $sql_done_deal = "INSERT INTO DEALS_DONE (previous_team, new_team, player_name, transfer_amount, salary_amount, deal_year)
                VALUES ('$previous_team', '$new_team', '$player_name', $transfer_offer, $salary_offer, YEAR(CURRENT_DATE))";

                if (mysqli_query($conn, $sql_done_deal)) {
                    // Remove the offer from the transfer_offer table
                    //$sql_delete_offer = "DELETE FROM TRANSFER_OFFER WHERE id = '$offer_id'";
                    //if (mysqli_query($conn, $sql_delete_offer)) {
                        echo "<p style='color: green;'>Offer accepted, and deal finalized for player '$player_name'.</p>";
                    //} else {
                    //    echo "<p style='color: red;'>Error deleting offer: " . mysqli_error($conn) . "</p>";
                    //}
                } else {
                    echo "<p style='color: red;'>Error finalizing deal: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<p style='color: red;'>Error fetching new team for manager ID: $manager_id.</p>";
            }
        } else {
            echo "<p style='color: red;'>Error fetching player's current team.</p>";
        }
    } elseif ($action === 'reject') {
        // Reject the offer by deleting it from the transfer_offer table
        $sql_delete_offer = "DELETE FROM TRANSFER_OFFER WHERE id = '$offer_id'";
        if (mysqli_query($conn, $sql_delete_offer)) {
            echo "<p style='color: green;'>Offer rejected for player '$player_name'.</p>";
        } else {
            echo "<p style='color: red;'>Error rejecting offer: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Invalid action.</p>";
    }
}

$conn->close();
?>