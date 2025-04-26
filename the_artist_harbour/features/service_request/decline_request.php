<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];

    $sql = "UPDATE service_requests SET status = 'declined' WHERE id = $request_id";

    $result = DatabaseHandler::make_modify_query($sql);

    if ($result) {
        header("Location: service_request_page.php");
    } else {
        header("Location: service_request_page.php");
    }
    exit();
}
?>