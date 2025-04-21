<?php
    require_once(__DIR__ . "/../../utilities/databaseHandler.php");
    require_once(__DIR__ . "/../service_request/serviceRequestHandler.php");

    $service_id = $_POST['service_id'];
    $sender_id = $_POST['sender_id'];
    $message = $_POST['message'];
    
    if($_POST['price'] == "0"){
        $result = serviceRequestHandler::insertRequest($sender_id, $service_id, $message);
    }else{
        $price = $_POST['price'];
        $result = serviceRequestHandler::insertRequest($sender_id, $service_id, $message, $price);
    }

    if($result == true){
        header("Location: service.php?service_id=$service_id&outcome=success&action=2");
    }else{
        header("Location: service.php?service_id=$service_id&outcome=success&action=2");
    }
    exit();

?>