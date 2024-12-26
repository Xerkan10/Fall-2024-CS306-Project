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

    function send_msg($msg, $name, $msg_type) {
        global $URL;
        $ch = curl_init();
        $msg_json = [
            "msg" => $msg,
            "name" => $name,
            "msg_type" => $msg_type, // Add message type
            "time" => date('H:i')
        ];
        $encoded_json_obj = json_encode($msg_json);
        curl_setopt_array($ch, [
            CURLOPT_URL => $URL,
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => $encoded_json_obj
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    // Process form submission
    $username = $_POST['username'] ?? '';
    $usermsg = $_POST['usermsg'] ?? '';
    $msg_type = $_POST['messageType'] ?? ''; // Retrieve message type
    $send_message = isset($_POST['send_message']);
    $view_messages = isset($_POST['view_messages']);

    // If "Send Message" is clicked, add the message
    if ($send_message && $username && $usermsg && $msg_type) {
        send_msg($usermsg, $username, $msg_type);
    }

    // Filter messages for the current user
    $messages = get_messages();
    $user_messages = array_filter($messages, function ($message) use ($username) {
        return $message['name'] === $username;
    });
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Messages</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="chat-box">
        <h1>Messages for <?= htmlspecialchars($username) ?></h1>

        <!-- Chat Messages -->
        <ol class="chat">
            <?php if (!empty($user_messages)): ?>
                <?php foreach ($user_messages as $message): ?>
                    <li class="self">
                        <div class="msg">
                            <p><b><?= htmlspecialchars($message['name']) ?></b></p>
                            <p><b>Message Type:</b> <?= htmlspecialchars($message['msg_type'] ?? 'Not Specified') ?></p>
                            <p><b>Message:</b> <?= htmlspecialchars($message['msg']) ?></p>
                            <time><b>Time:</b> <?= htmlspecialchars($message['time']) ?></time>
                            <p><b>Response:</b> 
                                <?= htmlspecialchars($message['response'] ?? 'This message is being processed') ?>
                            </p>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No messages found.</p>
            <?php endif; ?>
        </ol>

        <!-- Back Button -->
        <form method="GET" action="start_support.php">
            <button type="submit">Back</button>
        </form>
    </div>
</body>
</html>
