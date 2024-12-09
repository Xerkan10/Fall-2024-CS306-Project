<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manager Player List</title>
    <script>
        function toggleRequired(rowId) {
            // Remove "required" from all transfer amount inputs
            const allInputs = document.querySelectorAll('input.transfer-amount');
            allInputs.forEach(input => input.removeAttribute('required'));

            // Add "required" to the selected row's input
            const selectedInput = document.getElementById('transfer_amount_dollars_' + rowId);
            selectedInput.setAttribute('required', 'required');
        }
    </script>
</head>
<body>
    <h1>Manager Player List</h1>

    <!-- Back to Home -->
    <form action="football.html" method="GET">
        <button type="submit">Go to Homepage</button>
    </form>

    <!-- Display Error Message -->
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <!-- Display Player List -->
    <?php if (!empty($players)): ?>
        <h3>Players Managed by You</h3>
        <form action="submit_to_transfer_list.php" method="POST">
            <table border="1">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Player ID</th>
                        <th>Player Name</th>
                        <th>Position</th>
                        <th>Team</th>
                        <th>Transfer Amount ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $index => $player): ?>
                        <tr>
                            <td>
                                <input 
                                    type="radio" 
                                    id="player_id_<?php echo $index; ?>" 
                                    name="player_id" 
                                    value="<?php echo $player['player_id']; ?>" 
                                    onclick="toggleRequired(<?php echo $index; ?>)" 
                                    required 
                                />
                            </td>
                            <td><?php echo htmlspecialchars($player['player_id']); ?></td>
                            <td><?php echo htmlspecialchars($player['player_name']); ?></td>
                            <td><?php echo htmlspecialchars($player['player_position']); ?></td>
                            <td><?php echo htmlspecialchars($player['team_name']); ?></td>
                            <td>
                                <input 
                                    type="number" 
                                    id="transfer_amount_dollars_<?php echo $index; ?>" 
                                    name="transfer_amount_dollars[<?php echo $player['player_id']; ?>]" 
                                    class="transfer-amount" 
                                    placeholder="Enter Amount" 
                                />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit">Add to Transfer List</button>
        </form>
    <?php else: ?>
        <p>No players found for this manager.</p>
    <?php endif; ?>
</body>
</html>
