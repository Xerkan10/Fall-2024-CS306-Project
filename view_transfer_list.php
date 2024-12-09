<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Transfer List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            margin-top: 10px;
        }
    </style>
    <script>
        function toggleRequired(selectedId) {
            const salaryInputs = document.querySelectorAll('input[type="number"]');
            salaryInputs.forEach(input => input.removeAttribute('required'));

            const selectedInput = document.getElementById('offer_salary_' + selectedId);
            if (selectedInput) {
                selectedInput.setAttribute('required', 'required');
            }
        }
    </script>
</head>
<body>
    <h1>Transfer List</h1>

    <!-- Back to Home -->
    <form action="football.html" method="GET">
        <button type="submit">Go to Homepage</button>
    </form>

    <!-- Display Error Message -->
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <!-- Display Transfer List -->
    <?php if (!empty($transfers)): ?>
        <h3>All Players in Transfer List</h3>
        <form action="submit_transfer_offer_within_transfer_list.php" method="POST">
            <!-- Input for Manager ID -->
            <label for="manager_id">Enter Manager ID:</label>
            <input type="text" id="manager_id" name="manager_id" placeholder="Manager ID" required />
            <br><br>

            <!-- Include team name as a hidden input -->
            <input type="hidden" name="team_name" value="<?php echo htmlspecialchars($team_name); ?>" />

            <table>
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Player Name</th>
                        <th>Team Name</th>
                        <th>Agent Name</th>
                        <th>Transfer Amount ($)</th>
                        <th>Offer Salary ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transfers as $index => $transfer): ?>
                        <tr>
                            <td>
                                <input 
                                    type="radio" 
                                    id="transfer_id_<?php echo $index; ?>" 
                                    name="player_name" 
                                    value="<?php echo htmlspecialchars($transfer['player_name']); ?>" 
                                    onclick="toggleRequired(<?php echo $index; ?>)" 
                                    required 
                                />
                            </td>
                            <td><?php echo htmlspecialchars($transfer['player_name']); ?></td>
                            <td><?php echo htmlspecialchars($transfer['team_name']); ?></td>
                            <td><?php echo htmlspecialchars($transfer['agent_name']); ?></td>
                            <td><?php echo htmlspecialchars($transfer['transfer_amount']); ?></td>
                            <td>
                                <input 
                                    type="number" 
                                    id="offer_salary_<?php echo $index; ?>" 
                                    name="offer_amount_dollars" 
                                    placeholder="Enter Salary" 
                                />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit">Submit Offer</button>
        </form>
    <?php else: ?>
        <p>No players found in the transfer list.</p>
    <?php endif; ?>
</body>
</html>
