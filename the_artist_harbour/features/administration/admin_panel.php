<?php
session_start();
$_SESSION["user_type"] = "admin"; // for testing purposes

//if (!isset($_SESSION["user_id"])) {
//    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/registration-login/login.php");
//    exit();
//}
//
//if ($_SESSION["user_type"] !== "business") {
//    // do something
//    print "You are not authorized to view this page";
//    exit();
//}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Artist Harbour</title>
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        div {
            padding: 0 !important;
        }

        .request-title-container {
            background-color: #E2D4F0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 93.82px;
            border-bottom: #B3AABA 2px solid;
        }

        .request-title-container p {
            font-size: 1.5rem;
            color: #49375a;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .requests {
            margin: 40px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row g-0">
        <div class="col-12">
            <?php include __DIR__ . '/../../templates/header.php'; ?>
        </div>
    </div>

    <div class="row g-0">
        <div class="col-10 col-md-12">
            <div class="request-title-container">
                <p>Report Logs</p>
            </div>

            <div class="requests">
                <?php include 'render_all_reports.php'; ?>
                <?php include 'render_report_details_modals.php'; ?>
            </div>
        </div>

    </div>
</div>
</body>
</html>
