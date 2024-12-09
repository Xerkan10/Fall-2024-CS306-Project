<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = $conn->real_escape_string($_POST['team_name']);
    $age = isset($_POST['age']) ? intval($_POST['age']) : null;
    $position = isset($_POST['position']) ? $conn->real_escape_string($_POST['position']) : null;
    $foot = isset($_POST['foot']) ? $conn->real_escape_string($_POST['foot']) : null;

    $conditions = ["team_name = '$team_name'"];
    if ($age) $conditions[] = "age > $age";
    if ($position) $conditions[] = "position = '$position'";
    if ($foot) $conditions[] = "foot = '$foot'";

    $sql = "SELECT * FROM PLAYER WHERE " . implode(' AND ', $conditions);
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    echo "<h1>Filtered Players in Team: $team_name</h1>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Player ID: " . $row['player_id'] . ", Name: " . $row['name'] . ", Position: " . $row['position'] . ", Age: " . $row['age'] . "<br>";
        }
    } else {
        echo "No players match the given criteria in team $team_name.";
    }
    $conn->close();
}
?>
