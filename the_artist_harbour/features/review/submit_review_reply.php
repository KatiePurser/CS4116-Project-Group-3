<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'];
    $review_response_text = $_POST['review_response_text'];

    $sql = "INSERT INTO review_replies (review_id, text, created_at) 
            VALUES ('$review_id', '$review_response_text', NOW())";

    $result = DatabaseHandler::make_modify_query($sql);

    header("Location: profile.php");
    exit();
}
?>