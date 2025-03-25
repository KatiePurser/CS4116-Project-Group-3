<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

$response = [];

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
            $response[] = [
                'id' => $message['id'],
                'sender_id' => $message['sender_id'],
                'text' => $message['text'],
                'created_at' => $message['created_at'],
                'is_sender' => $is_sender,
                'status' => $message['status']
            ];
        }
    } else {
        $response['error'] = "No messages found between you and this sender.";
    }
} else {
    $response['error'] = "Please select a conversation!";
}

return $response;
?>