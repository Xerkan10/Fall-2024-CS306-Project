<?php
    require_once 'constants.php';
    $URL = FIREBASE_URL;

    // Functions to interact with Firebase
    function get_messages() {
        global $URL;
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $URL,
            CURLOPT_POST => FALSE, // It will be a GET request
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $messages = json_decode($response, true);
    
        return $messages ?? [];
    }

    function add_response($message_id, $response) {
        $url = FIREBASE_URL_BASE;
        $ch = curl_init();
        $response_json = [
            "response" => $response,
        ];
        $encoded_json_obj = json_encode($response_json);
    
        curl_setopt_array($ch, [
            CURLOPT_URL => $url . "/$message_id.json",
            CURLOPT_CUSTOMREQUEST => "PATCH", // Use PATCH to add the response
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => $encoded_json_obj,
        ]);
    
        $response = curl_exec($ch);
    
        curl_close($ch);
        return $response;
    }
    
    // Process admin response submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'], $_POST['admin_response'])) {
        $message_id = $_POST['message_id'];
        $admin_response = $_POST['admin_response'];
        add_response($message_id, $admin_response);
        header("Location: admin.php"); // Redirect to avoid form resubmission
        exit();
    }

    // Fetch all messages
    $messages = get_messages();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="chat-box">
        <h1>Admin Panel</h1>

        <!-- Display All Messages -->
        <ol class="chat">
            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $id => $message): ?>
                    <li class="message">
                        <div class="msg">
                            <p><b>Name:</b> <?= htmlspecialchars($message['name'] ?? 'Unknown') ?></p>
                            <p><b>Message Type:</b> <?= htmlspecialchars($message['msg_type'] ?? 'Not specified') ?></p>
                            <p><b>Message:</b> <?= htmlspecialchars($message['msg'] ?? 'No message') ?></p>
                            <p><b>Time:</b> <?= htmlspecialchars($message['time'] ?? 'No time') ?></p>
                            <p><b>Response:</b> <?= htmlspecialchars($message['response'] ?? 'No response yet') ?></p>

                            <!-- Form to Add a Response -->
                            <form method="POST" action="admin.php">
                                <input type="hidden" name="message_id" value="<?= htmlspecialchars($id) ?>">
                                <textarea name="admin_response" placeholder="Type your response here" required></textarea>
                                <button type="submit">Submit Response</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No messages found.</p>
            <?php endif; ?>
        </ol>
    </div>
</body>
</html>
