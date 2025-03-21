<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reporter_id = $_POST['reporter_id'];
    $reported_id = $_POST['reported_id'];
    $target_type = $_POST['target_type'];
    $target_id = $_POST['message_id'];
    $reason = $_POST['reason'];
    $status = 'pending';

    $sql = "INSERT INTO reports (reporter_id, reported_id, target_type, target_id, reason, status, created_at) 
            VALUES ('$reporter_id', '$reported_id', '$target_type', '$target_id', '$reason', '$status', NOW())";

    $result = DatabaseHandler::make_modify_query($sql);

    if ($result) {
        header("Location: inbox.php?sender_id=$reported_id&report=success");
    } else {
        header("Location: inbox.php?sender_id=$reported_id&report=failure");
    }
    exit();
}
?>