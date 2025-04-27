<?php
// Include the database handler to allow DB interactions
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

// Get the current logged-in user's ID from session
$user_id = $_SESSION['user_id'];

// SQL query to fetch conversations for the current user, along with the other user's name and the latest message
$sql = "
    SELECT 
        c.id AS conversation_id,
        CASE 
            WHEN c.user1_id = $user_id THEN c.user2_id -- If current user is user1, get user2's ID
            ELSE c.user1_id -- Otherwise, get user1's ID
        END AS other_user_id,
        u.first_name,
        u.last_name,
        c.created_at AS conversation_created_at,

        m.id AS message_id,
        m.sender_id,
        m.receiver_id,
        m.text,
        m.status,
        m.created_at AS message_created_at

    FROM conversations c

    -- Join with users table to fetch the other user's details
    JOIN users u ON u.id = CASE 
                            WHEN c.user1_id = $user_id THEN c.user2_id
                            ELSE c.user1_id
                        END

    -- Join the latest message for each conversation using a subquery
    LEFT JOIN messages m ON m.id = (
        SELECT id
        FROM messages
        WHERE conversation_id = c.id
        ORDER BY created_at DESC -- Get the most recent message
        LIMIT 1
    )

    -- Only select conversations where the current user is involved
    WHERE $user_id IN (c.user1_id, c.user2_id)

    -- Order conversations primarily by latest message date, then by conversation creation date
    ORDER BY 
        m.created_at DESC, 
        c.created_at DESC
";

$results = DatabaseHandler::make_select_query($sql);

$conversations = [];

if ($results != null) {
    foreach ($results as $result) {
        // Build the full name of the other user
        $other_user_name = $result['first_name'] . ' ' . $result['last_name'];

        // Build a conversation entry
        $conversations[] = [
            'conversation_id' => $result['conversation_id'],
            'other_user_id' => $result['other_user_id'],
            'other_user' => $other_user_name,
            'created_at' => $result['conversation_created_at'],

            // Add latest message details as a nested array
            'latest_message' => [
                'message_id' => $result['message_id'],
                'sender_id' => $result['sender_id'],
                'receiver_id' => $result['receiver_id'],
                'text' => $result['text'],
                'status' => $result['status'],
                'created_at' => $result['message_created_at'],
            ]
        ];
    }
}

return $conversations;
?>