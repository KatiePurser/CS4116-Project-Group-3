<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

$user_id = 2; // Replace with the actual ID
$sql = "SELECT m.sender_id, u.first_name, u.last_name, m.id AS message_id, m.created_at AS latest_message_time, m.status
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        JOIN (
            -- Getting the latest message_id for each of the senders
            SELECT sender_id, MAX(created_at) AS latest_message_time
            FROM messages
            WHERE receiver_id = $user_id
            GROUP BY sender_id
            ) latest_messages ON m.sender_id = latest_messages.sender_id AND m.created_at = latest_messages.latest_message_time
        WHERE m.receiver_id = $user_id
        ORDER BY m.created_at DESC";


$messages = DatabaseHandler::make_select_query($sql);

$senders = []; // Stores sender IDs and their names
$latest_messages = []; // Stores the latest message time and message ID for each sender
$latest_sender_id = null; // Stores the ID of the sender with the latest message
$latest_time = 0; // Store the latest message time

if ($messages !== null) {
    foreach ($messages as $message) {
        $senders[$message['sender_id']] = $message['first_name'] . ' ' . $message['last_name'];
        $latest_messages[$message['sender_id']] = [
            'time' => $message['latest_message_time'],
            'message_id' => $message['message_id'],
            'status' => $message['status']
        ];

        $time = strtotime($message['latest_message_time']);
        if ($time > $latest_time) {
            $latest_time = $time;
            $latest_sender_id = $message['sender_id'];
        }
    }
}

return [
    'senders' => $senders,
    'latest_message_time' => $latest_messages,
    'latest_sender_id' => $latest_sender_id
];
?>