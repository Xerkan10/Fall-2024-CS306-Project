<!DOCTYPE html>
<html>
<head>
    <title>Start Support Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for the layout */
        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 800px;
            margin: 0 auto;
        }
        .left, .right {
            width: 48%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label, form input, form select, form button {
            margin-bottom: 15px;
        }
        form button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Part: Send Message -->
        <div class="left">
            <h2>Send Message</h2>
            <form id="sendMessageForm" method="POST" action="view_messages.php" onsubmit="return validateSendMessageForm()">
                <label for="username"><b>Name:</b></label>
                <input name="username" id="username" type="text" placeholder="Enter your name" required />

                <label for="messageType"><b>Message Type:</b></label>
                <select name="messageType" id="messageType" required>
                    <option value="" disabled selected>Select message type</option>
                    <option value="Salary update">Salary update</option>
                    <option value="Transfer offer for our player">Transfer offer for our player</option>
                    <option value="Transfer offer to player">Transfer offer to player</option>
                    <option value="Complaint about club">Complaint about club</option>
                    <option value="Meeting request">Meeting request</option>
                    <option value="New equipment need">New equipment need</option>
                    <option value="Injury report">Injury report</option>
                </select>

                <label for="usermsg"><b>Message:</b></label>
                <input name="usermsg" id="usermsg" type="text" placeholder="Type your message" required />

                <button type="submit" name="send_message" value="true">Send Message</button>
            </form>
        </div>

        <!-- Right Part: View Messages -->
        <div class="right">
            <h2>View Messages</h2>
            <form id="viewMessagesForm" method="POST" action="view_messages.php" onsubmit="return validateViewMessagesForm()">
                <label for="viewUsername"><b>Name:</b></label>
                <input name="username" id="viewUsername" type="text" placeholder="Enter your name" required />

                <button type="submit" name="view_messages" value="true">View Messages</button>
            </form>
        </div>
    </div>

    <script>
        // Validate Send Message Form
        function validateSendMessageForm() {
            const name = document.getElementById('username').value.trim();
            const messageType = document.getElementById('messageType').value;
            const message = document.getElementById('usermsg').value.trim();

            if (!name) {
                alert("Please enter your name.");
                return false;
            }

            if (!messageType) {
                alert("Please select a message type.");
                return false;
            }

            if (!message) {
                alert("Please enter a message.");
                return false;
            }

            return true;
        }

        // Validate View Messages Form
        function validateViewMessagesForm() {
            const name = document.getElementById('viewUsername').value.trim();

            if (!name) {
                alert("Please enter your name.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
