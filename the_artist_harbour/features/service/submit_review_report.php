<!-- reporter_id, reported_id, target_type, target_id, reason, status -->
<?php
    require_once(__DIR__ . "/../../utilities/databaseHandler.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $service_id=$_POST['service_id'];
        if(($_POST['service_id']) != '36'){
            header("Location: service.php?service_id=$service_id&report=failure&service_id");
            exit();
        };
        $reporter_id=$_POST['reporter_id'];
        if(!isset($_POST['reporter_id'])){
            header("Location: service.php?service_id=$service_id&report=failure&reporter_id");
            exit();
        };
        $reported_id=$_POST['reported_id'];
        if(!isset($_POST['reported_id'])){
            header("Location: service.php?service_id=$service_id&report=failure&reported_id");
            exit();
        };
        $review_content=$_POST['review_content'];
        $review_id=$_POST['review_id'];
        if(!isset($_POST['review_id'])){
            header("Location: service.php?service_id=$service_id&report=failure&review_id");
            exit();
        };
        $reason=$_POST['reason'];
        if(!isset($_POST['reason'])){
            header("Location: service.php?service_id=$service_id&report=failure&reason");
            exit();
        };


        $sql = "INSERT INTO reports (reporter_id, reported_id, target_type, target_id, reason, status)
                    VALUES ('$reporter_id', '$reported_id', 'review', '$review_id', '$reason', 'pending')";
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