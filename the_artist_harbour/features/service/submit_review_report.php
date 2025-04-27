<!-- reporter_id, reported_id, target_type, target_id, reason, status -->
<?php
    require_once(__DIR__ . "/../../utilities/databaseHandler.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $service_id=$_POST['service_id'];
        $reporter_id=$_POST['reporter_id'];
        $reported_id=$_POST['reported_id'];
        $review_content=$_POST['review_content'];
        $review_id=$_POST['review_id'];
        $reason=htmlspecialchars($_POST['reason']);

        $sql = "INSERT INTO reports (reporter_id, reported_id, target_type, target_id, reason, status, target_content)
                    VALUES ('$reporter_id', '$reported_id', 'review', '$review_id', '$reason', 'pending', '$review_content')";
        $result = DatabaseHandler::make_modify_query($sql);

        //process and send user back based on result
        if ($result) {
            header("Location: service.php?service_id=$service_id&outcome=success&action=0");
        } else {
            header("Location: service.php?service_id=$service_id&outcome=failure&action=0");
        }
        exit();

    };
?>