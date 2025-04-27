<?php
// Include the database handler to allow DB interactions
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

// Get the current logged-in user's ID from session
$current_user_id = $_SESSION['user_id'];

// Fetch the latest conversation ID by requiring another script
$latest_conversation_id = require_once 'fetch_latest_conversation.php';

// Determine which conversation ID to use: from GET parameter if available, otherwise fallback to the latest conversation
$conversation_id = isset($_GET['conversation_id']) ? (int) $_GET['conversation_id'] : $latest_conversation_id;

// SQL query to fetch all messages from the selected conversation, along with sender and receiver full names
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

    -- Join users table to get the sender's information
    JOIN users sender ON sender.id = m.sender_id

    -- Join users table to get the receiver's information
    JOIN users receiver ON receiver.id = m.receiver_id

    -- Only fetch messages belonging to the selected conversation
    WHERE m.conversation_id = $conversation_id

    -- Order the messages by creation time in ascending order (oldest first)
    ORDER BY m.created_at ASC
";

$messages = DatabaseHandler::make_select_query($sql);

$other_user_name = null;

// If there are messages, determine the name of the other user based on the first message
if (!empty($messages)) {
    $first_message = $messages[0];

    // If the first message was sent by the current user, the other user is the receiver
    if ($first_message['sender_id'] == $current_user_id) {
        $other_user_name = $first_message['receiver_name'];
    }
    // Otherwise, the other user is the sender
    else {
        $other_user_name = $first_message['sender_name'];
    }
}

return [
    'messages' => $messages,
    'other_user_name' => $other_user_name,
    'conversation_id' => $conversation_id
];
?>