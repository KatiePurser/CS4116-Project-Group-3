<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';

if (isset($_GET['sender_id'])) {
    $sender_id = $_GET['sender_id'];
    $receiver_id = 2; // Replace with real ID

    $sql = "SELECT * FROM messages 
            WHERE (sender_id = $sender_id AND receiver_id = $receiver_id) 
               OR (sender_id = $receiver_id AND receiver_id = $sender_id) 
            ORDER BY created_at ASC";
    $messages = DatabaseHandler::make_select_query($sql);

    if ($messages !== null && count($messages) > 0) {
        foreach ($messages as $message) {
            $is_sender = $message['sender_id'] == $sender_id;
            $message_class = $is_sender ? 'sender-message' : 'receiver-message';
            echo "<div class='message $message_class'>";
            echo "<p>" . $message['text'] . "</p>";
            echo "<small>Sent on: " . $message['created_at'] . "</small>";
            echo "</div><hr>";
        }
    } else {
        echo "No messages found between you and this sender.";
    }
} else {
    echo "<h1>Select a conversation to view</h1>";
}
?>