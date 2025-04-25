<?php
    require_once(__DIR__ . "/../../utilities/databaseHandler.php");
    require_once(__DIR__ . "/../service_request/serviceRequestHandler.php");

    // $service_id = $_POST['service_id'];
    // if($_POST['service_id'] == ""){
    //     header("Location: service.php?service_id=$service_id&report=failure&uhohservice");
    //     exit();
    // };
    // $sender_id = $_POST['sender_id'];
    // $message = $_POST['message'];
    // $price_min = $_POST['price_min'];
    // // if($_POST['price_min'] == ""){
    // //     header("Location: service.php?service_id=$service_id&report=failure&uhohpricemin");
    // //     exit();
    // // };
    // $price_max = $_POST['price_max'];
    // if($_POST['price_max'] == ""){
    //     header("Location: service.php?service_id=$service_id&report=failure&uhohpricemax");
    //     exit();
    // };

    $service_id = $_GET['service_id'];
    if($_GET['service_id'] == ""){
        header("Location: service.php?service_id=$service_id&report=failure&uhohservice");
        exit();
    };
    $sender_id = $_GET['sender_id'];
    $message = $_GET['message'];
    $price_min = $_GET['price_min'];
    // if($_POST['price_min'] == ""){
    //     header("Location: service.php?service_id=$service_id&report=failure&uhohpricemin");
    //     exit();
    // };
    $price_max = $_GET['price_max'];
    if($_GET['price_max'] == ""){
        header("Location: service.php?service_id=$service_id&report=failure&uhohpricemax");
        exit();
    };

    $result = serviceRequestHandler::insertRequest($sender_id, $service_id, $message, $price_min, $price_max);


    if($result == true){
        header("Location: service.php?service_id=$service_id&outcome=success&action=2");
    }else{
        header("Location: service.php?service_id=$service_id&outcome=success&action=2");
    }
    exit();

?>