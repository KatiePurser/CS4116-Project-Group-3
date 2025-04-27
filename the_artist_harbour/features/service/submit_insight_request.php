<?php
require_once(__DIR__ . "/../../utilities/databaseHandler.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'];
    $service_name = DatabaseHandler::make_select_query("SELECT name FROM services WHERE id=$service_id");
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];
    $final_message = htmlspecialchars("Insight Request (" . $service_name[0]['name'] . "): " . $message);

    $conversation = DatabaseHandler::make_select_query("SELECT id FROM conversations WHERE (user1_id=$sender_id AND user2_id=$receiver_id) OR (user1_id=$receiver_id AND user2_id=$sender_id)");
    if ($conversation == NULL) {
        $sql = "CALL SendMessage('$sender_id', '$receiver_id', '$final_message', 'pending')";
    } else {
        $conversation_id = $conversation[0]['id'];
        $conversation_pending = DatabaseHandler::make_select_query("SELECT id FROM messages WHERE (conversation_id=$conversation_id) AND (status='pending')");
        if ($conversation_pending == NULL) {
            $sql = "CALL SendMessage('$sender_id', '$receiver_id', '$final_message', 'accepted')";
        } else {
            $sql = "CALL SendMessage('$sender_id', '$receiver_id', '$final_message', 'pending')";
        }
    }
    $result = DatabaseHandler::make_modify_query($sql);

    //process and send user back based on result
    if ($result) {
        header("Location: service.php?service_id=$service_id&outcome=success&action=1");
    } else {
        header("Location: service.php?service_id=$service_id&outcome=failure&action=1");
    }
    exit();

}
;
?>