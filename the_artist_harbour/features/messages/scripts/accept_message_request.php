<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conversation_id = $_POST['conversation_id'];
    $action = $_POST['action'];


    if ($action === 'accept') {
        $sql = "UPDATE messages SET status = 'accepted' WHERE conversation_id = $conversation_id";
    } elseif ($action === 'decline') {
        $sql = "DELETE FROM conversations WHERE id = $conversation_id";
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