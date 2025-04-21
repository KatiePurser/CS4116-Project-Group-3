<?php
    require_once(__DIR__ . "/../../utilities/databaseHandler.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $service_id=$_POST['service_id'];
        if(!isset($_POST['service_id'])){
            header("Location: service.php?service_id=$service_id&report=failure&uhoh");
            exit();
        };
        $sender_id=$_POST['sender_id'];
        $receiver_id=$_POST['receiver_id'];
        $message=$_POST['message'];

        $sql = "CALL SendMessage('$sender_id', '$receiver_id', '$message', 'pending')";
        $result = DatabaseHandler::make_modify_query($sql);

        //process and send user back based on result
        if ($result) {
            header("Location: service.php?service_id=$service_id&outcome=success&action=1");
        } else {
            header("Location: service.php?service_id=$service_id&outcome=failure&action=1");
        }
        exit();

    };
?>