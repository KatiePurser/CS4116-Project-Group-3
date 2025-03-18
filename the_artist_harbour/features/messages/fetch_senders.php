<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';

$user_id = 2; // Replace with the actual ID
$query = "SELECT messages.*, users.first_name, users.last_name 
          FROM messages 
          JOIN users ON messages.sender_id = users.id 
          WHERE messages.receiver_id = $user_id";

$messages = DatabaseHandler::make_select_query($query);

$senders = [];
if ($messages !== null) {
    foreach ($messages as $message) {
        $senders[$message['sender_id']] = $message['first_name'] . ' ' . $message['last_name'];
    }
}
?>