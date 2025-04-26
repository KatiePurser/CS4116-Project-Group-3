<?php
    require_once(__DIR__ . "/../../utilities/databaseHandler.php");
    require_once(__DIR__ . "/../service_request/serviceRequestHandler.php");

    $service_id = $_GET['service_id'];
    $service_name = DatabaseHandler::make_select_query("SELECT name FROM services WHERE id=$service_id");
    $sender_id = $_GET['sender_id'];
    $message = $_GET['message'];
    $final_message = "Service Request (".$service_name[0]['name']."): ".$message;
    $price_min = $_GET['price_min'];
    $price_max = $_GET['price_max'];

    $result = serviceRequestHandler::insertRequest($sender_id, $service_id, $final_message, $price_min, $price_max);


    if($result == true){
        header("Location: service.php?service_id=$service_id&outcome=success&action=2");
    }else{
        header("Location: service.php?service_id=$service_id&outcome=success&action=2");
    }
    exit();

?>