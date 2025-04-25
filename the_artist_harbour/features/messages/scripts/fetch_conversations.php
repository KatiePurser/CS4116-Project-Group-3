<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

$user_id = $_SESSION['user_id'];

$sql = "
        SELECT 
            c.id AS conversation_id,
            CASE 
                WHEN c.user1_id = $user_id THEN c.user2_id
                ELSE c.user1_id
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

        -- Get the other user
        JOIN users u ON u.id = CASE 
                                WHEN c.user1_id = $user_id THEN c.user2_id
                                ELSE c.user1_id
                            END

        -- Join latest message for each conversation
        LEFT JOIN messages m ON m.id = (
            SELECT id
            FROM messages
            WHERE conversation_id = c.id
            ORDER BY created_at DESC
            LIMIT 1
        )

        WHERE $user_id IN (c.user1_id, c.user2_id)

        ORDER BY 
            m.created_at DESC, 
            c.created_at DESC
    ";


$results = DatabaseHandler::make_select_query($sql);

$conversations = [];

if ($results != null) {
    foreach ($results as $result) {
        $other_user_name = $result['first_name'] . ' ' . $result['last_name'];

        $conversations[] = [
            'conversation_id' => $result['conversation_id'],
            'other_user_id' => $result['other_user_id'],
            'other_user' => $other_user_name,
            'created_at' => $result['conversation_created_at'],

            // Include latest message details
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