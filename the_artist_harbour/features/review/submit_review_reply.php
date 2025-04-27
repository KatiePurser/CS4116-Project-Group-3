<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'];
    $review_response_text = htmlspecialchars($_POST['review_response_text']);

    $sql = "INSERT INTO review_replies (review_id, text, created_at) 
            VALUES ('$review_id', '$review_response_text', NOW())";

    $result = DatabaseHandler::make_modify_query($sql);

    $page = $_POST['page'];
    if($page === "service") {
        $service_id = $_POST['service_id'];
        header("Location: ../service/service.php?service_id=$service_id");
        exit();
    } else if ($page === "profile") {
        $business_id = $_POST['business_id'];
        $review_page = $_POST['review_page'];
        $sort = $_POST['sort'];
        header("Location: ../business/profile.php?business_id=$business_id&review_page=$review_page&sort=$sort");
        exit();
    };
}
?>