<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_user_id = $_SESSION['user_id'];
    $conversation_id = $_POST['conversation_id'];
    $message_text = $_POST['message_text'];

    $sql = "SELECT user1_id, user2_id FROM conversations WHERE id = $conversation_id";
    $result = DatabaseHandler::make_select_query($sql);

    $user1_id = $result[0]['user1_id'];
    $user2_id = $result[0]['user2_id'];

    $other_user_id = ($current_user_id === $user1_id) ? $user2_id : $user1_id;

    $sql = "CALL SendMessage($current_user_id, $other_user_id, '$message_text', 'accepted')";
    $result = DatabaseHandler::make_modify_query($sql);

    if ($result) {
        header("Location: ../inbox.php?conversation_id=$conversation_id");
    }
    exit();
}
?>