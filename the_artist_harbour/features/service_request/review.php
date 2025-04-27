<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'];
    $reviewer_id = $_SESSION['user_id'];
    $text = htmlspecialchars($_POST['review']);
    $rating = $_POST['rating'];
    $request_id = $_POST['request_id'];

    $sql = "INSERT INTO reviews (service_id, reviewer_id, text, rating, created_at)
            VALUES ($service_id, $reviewer_id, '$text', $rating, NOW())";
    $result = DatabaseHandler::make_modify_query($sql);

    $sql = "UPDATE service_requests SET reviewed = 1 WHERE id = $request_id";
    $result = DatabaseHandler::make_modify_query($sql);

    if ($result) {
        header("Location: ../service/service.php?service_id=$service_id");
    } else {
        header("Location: service_request_page.php");
    }
    exit();
}
?>