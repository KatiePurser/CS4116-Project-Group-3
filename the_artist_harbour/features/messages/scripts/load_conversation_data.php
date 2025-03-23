<?php
$data = require __DIR__ . '/fetch_senders.php';
$senders = $data['senders'];
$latest_messages = $data['latest_message_time'];
$latest_sender_id = $data['latest_sender_id'];

if (!isset($_GET['sender_id'])) {
    header("Location: ?sender_id=$latest_sender_id");
    exit();
}

$sender_id = $_GET['sender_id'];
$sender_name = $senders[$sender_id] ?? 'Sender Name';
$conversation = require __DIR__ . '/fetch_message_content.php';
?>