<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

$conversations = [];
$user_id = $_SESSION['user_id'];

$sql = "
    SELECT 
        c.id AS conversation_id,
        c.created_at AS conversation_created_at,
        CASE 
            WHEN c.user1_id = $user_id THEN c.user2_id
            ELSE c.user1_id
        END AS other_user_id,
        u.first_name,
        u.last_name,
        (
            SELECT MAX(m.created_at)
            FROM messages m
            WHERE m.conversation_id = c.id
        ) AS latest_message_time,
        (
            SELECT m.status
            FROM messages m
            WHERE m.conversation_id = c.id
            ORDER BY m.created_at ASC
            LIMIT 1
        ) AS first_message_status
    FROM conversations c
    JOIN users u ON u.id = CASE 
                            WHEN c.user1_id = $user_id THEN c.user2_id
                            ELSE c.user1_id
                          END
    WHERE c.user1_id = $user_id OR c.user2_id = $user_id
    ORDER BY 
    latest_message_time IS NULL, 
    latest_message_time DESC
";

$results = DatabaseHandler::make_select_query($sql);

if ($results != null) {
    foreach ($results as $result) {
        $other_user_name = $result['first_name'] . ' ' . $result['last_name'];

        $conversations[] = [
            'conversation_id' => $result['conversation_id'],
            'other_user_id' => $result['other_user_id'],
            'other_user' => $other_user_name,
            'created_at' => $result['conversation_created_at'],
            'latest_message_time' => $result['latest_message_time'],
            'status' => $result['first_message_status']
        ];
    }
}

return $conversations;
?>