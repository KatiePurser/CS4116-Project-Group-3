<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT 
        c.id AS conversation_id
    FROM conversations c
    LEFT JOIN messages m ON m.conversation_id = c.id
    WHERE c.user1_id = $user_id OR c.user2_id = $user_id
    GROUP BY c.id
    ORDER BY MAX(m.created_at) IS NULL, MAX(m.created_at) DESC
    LIMIT 1
";

$result = DatabaseHandler::make_select_query($sql);

if ($result != null && count($result) > 0) {
    $latest_conversation_id = $result[0]['conversation_id'];
    return $latest_conversation_id;
}

exit();
?>