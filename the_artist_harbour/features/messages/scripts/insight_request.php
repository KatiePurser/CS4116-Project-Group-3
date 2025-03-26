<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message_id = $_POST['message_id'];
    $action = $_POST['action'];
    $sender_id = $_POST['sender_id'];

    if ($action === 'accept') {
        $sql = "UPDATE messages SET status = 'accepted' WHERE id = $message_id";
    } elseif ($action === 'decline') {
        $sql = "UPDATE messages SET status = 'declined' WHERE id = $message_id";
    } else {
        header('Location: ../inbox.php?error=invalid_action');
        exit();
    }

    $result = DatabaseHandler::make_modify_query($sql);
    if ($result) {
        header("Location: ../inbox.php?sender_id=$sender_id");
    } else {
        header("Location: ../inbox.php?sender_id=$sender_id");
    }
    exit();
}
?>