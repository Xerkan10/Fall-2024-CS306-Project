<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $agent_id = $conn->real_escape_string($_POST['agent_id']); // Sanitize input

    // Fetch the agent's name
    $sql_agent = "SELECT agent_name FROM AGENT WHERE agent_id = '$agent_id'";
    $result_agent = mysqli_query($conn, $sql_agent);

    if ($result_agent && $result_agent->num_rows > 0) {
        $agent_row = $result_agent->fetch_assoc();
        $agent_name = $agent_row['agent_name'];
    } else {
        $agent_name = "Unknown Agent"; // Fallback if the name can't be fetched
    }

    // Fetch offers for the agent's players
    $sql_offers = "SELECT * FROM TRANSFER_OFFER WHERE agent_name = '$agent_name'";
    $result_offers = mysqli_query($conn, $sql_offers);

    if (!$result_offers) {
        die("Error fetching offers: " . mysqli_error($conn));
    }

    echo "<h1>Offers for {$agent_name}'s Players</h1>";

    if ($result_offers->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>Player Name</th>
                <th>Manager Name</th>
                <th>Transfer Offer ($)</th>
                <th>Salary Offer ($)</th>
                <th>Offer Date</th>
                <th>Actions</th>
              </tr>";

        while ($row = $result_offers->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['player_name']}</td>
                    <td>{$row['manager_name']}</td>
                    <td>{$row['transfer_offer']}</td>
                    <td>{$row['salary_offer']}</td>
                    <td>{$row['offer_date']}</td>
                    <td>
                        <form action='process_offer.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='offer_id' value='{$row['id']}'>
                            <input type='hidden' name='player_name' value='{$row['player_name']}'>
                            <input type='hidden' name='manager_name' value='{$row['manager_name']}'>
                            <input type='hidden' name='transfer_offer' value='{$row['transfer_offer']}'>
                            <input type='hidden' name='salary_offer' value='{$row['salary_offer']}'>
                            <button type='submit' name='action' value='accept'>Accept</button>
                            <button type='submit' name='action' value='reject'>Reject</button>
                        </form>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>No offers found for {$agent_name}'s players at the moment.</p>";
    }
}

$conn->close();
?>
