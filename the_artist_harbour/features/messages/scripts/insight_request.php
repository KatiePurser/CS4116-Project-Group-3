<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message_id = $_POST['message_id'];
    $action = $_POST['action'];

    if ($action === 'accept') {
        $sql = "UPDATE messages SET accepted = 1 WHERE id = $message_id";
    } elseif ($action === 'decline') {
        $sql = "DELETE FROM messages WHERE id = $message_id";
    } else {
        header('Location: ../inbox.php?error=invalid_action');
        exit();
    }

    $result = DatabaseHandler::make_modify_query($sql);
    if ($result) {
        header("Location: ../inbox.php");
    } else {
        header("Location: ../inbox.php");
    }
    exit();
}
?>