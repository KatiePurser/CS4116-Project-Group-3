<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';
$current_user_id = $_SESSION['user_id'];

$latest_conversation_id = require_once 'fetch_latest_conversation.php';
$conversation_id = isset($_GET['conversation_id']) ? (int) $_GET['conversation_id'] : $latest_conversation_id;

$sql = "
    SELECT 
        m.id,
        m.sender_id,
        m.receiver_id,
        m.text,
        m.status,
        m.created_at,
        m.conversation_id,
        CONCAT(sender.first_name, ' ', sender.last_name) AS sender_name,
        CONCAT(receiver.first_name, ' ', receiver.last_name) AS receiver_name
    FROM messages m
    JOIN users sender ON sender.id = m.sender_id
    JOIN users receiver ON receiver.id = m.receiver_id
    WHERE m.conversation_id = $conversation_id
    ORDER BY m.created_at ASC
";

$messages = DatabaseHandler::make_select_query($sql);

// Determine the other user's name from the first message
$other_user_name = null;
if (!empty($messages)) {
    $first_message = $messages[0];
    if ($first_message['sender_id'] == $current_user_id) {
        $other_user_name = $first_message['receiver_name'];
    } else {
        $other_user_name = $first_message['sender_name'];
    }
}

return [
    'messages' => $messages,
    'other_user_name' => $other_user_name,
    'conversation_id' => $conversation_id
];
?>