<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $request_id = $_POST['request_id'];
    $service_id = $_POST['service_id'];
    $created_at = $_POST['created_at'];
    $service_name = $_POST['service_name'];
    $price = $_POST['max_price']; // Default to max price initially

    // If a custom price is provided and valid, override the default price
    if (isset($_POST['custom_price']) && $_POST['custom_price'] > 0) {
        $price = $_POST['custom_price'];
    }

    $sql = "UPDATE service_requests 
            SET status = 'completed', max_price = $price, min_price = 0 
            WHERE id = $request_id";

    $result = DatabaseHandler::make_modify_query($sql);

    if ($result) {
        header("Location: service_request_page.php");
    } else {
        header("Location: service_request_page.php");
    }
    exit();
}
?>