<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reporter_id = $_POST['reporter_user_id'];
    $reported_id = $_POST['reported_user_id'];
    $target_type = $_POST['target_type'];
    $target_id = $_POST['message_id'];
    $reason = $_POST['reason'];
    $status = 'pending';
    $message_content = $_POST['message_content']; // TO BE USED WHEN ALEX NEEDS THE MESSAGE CONTENT IN THE DB
    $conversation_id = $_POST['conversation_id'];

    $sql = "INSERT INTO reports (reporter_id, reported_id, target_type, target_id, reason, status, created_at) 
            VALUES ('$reporter_id', '$reported_id', '$target_type', '$target_id', '$reason', '$status', NOW())";

    $result = DatabaseHandler::make_modify_query($sql);

    if ($result) {
        header("Location: ../inbox.php?conversation_id=$conversation_id&report=success");
    } else {
        header("Location: ../inbox.php?conversation_id=$conversation_id&report=failure");
    }
    exit();
}
?>