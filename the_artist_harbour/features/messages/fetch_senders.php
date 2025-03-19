<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';

$user_id = 5; // Replace with the actual ID
$query = "SELECT messages.sender_id, users.first_name, users.last_name, MAX(messages.created_at) as latest_message_time
          FROM messages 
          JOIN users ON messages.sender_id = users.id 
          WHERE messages.receiver_id = $user_id
          GROUP BY messages.sender_id, users.first_name, users.last_name
          ORDER BY latest_message_time DESC";

$messages = DatabaseHandler::make_select_query($query);

$senders = [];
$latest_message_time = [];
$latest_sender_id = null;
$latest_time = 0;

if ($messages !== null) {
    foreach ($messages as $message) {
        $senders[$message['sender_id']] = $message['first_name'] . ' ' . $message['last_name'];
        $latest_message_time[$message['sender_id']] = $message['latest_message_time'];

        $time = strtotime($message['latest_message_time']);
        if ($time > $latest_time) {
            $latest_time = $time;
            $latest_sender_id = $message['sender_id'];
        }
    }
}

return [
    'senders' => $senders,
    'latest_message_time' => $latest_message_time,
    'latest_sender_id' => $latest_sender_id
];
?>