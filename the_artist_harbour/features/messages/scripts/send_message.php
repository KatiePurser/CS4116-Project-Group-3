<?php
require_once __DIR__ . '/../../../utilities/databaseHandler.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_id = 2; // User ID
    $receiver_id = $_POST["receiver_id"];
    $message_text = trim($_POST["message_text"]);
    $status = 'accepted';

    $sql = "INSERT INTO messages (sender_id, receiver_id, text, status, created_at)
            VALUES ($sender_id, $receiver_id, '$message_text', $status, NOW())";

    $result = DatabaseHandler::make_modify_query($sql);

    if ($result) {
        header("Location: ../inbox.php?sender_id=$receiver_id");
    } else {
        header("Location: ../inbox.php?sender_id=$receiver_id");
    }

    exit();
}
?>