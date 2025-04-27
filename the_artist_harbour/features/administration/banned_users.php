<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: /the_artist_harbour/features/registration-login/login.php");
    exit();
}

if ($_SESSION["user_type"] !== "admin") {
    print "You are not authorized to view this page";
    exit();
}

// ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Artist Harbour</title>
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        div {
            padding: 0 !important;
        }

        .report-title-container {
            background-color: #E2D4F0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 93.82px;
            border-bottom: #B3AABA 2px solid;
        }

        .report-title-container p {
            font-size: 1.5rem;
            color: #49375a;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .banned-users {
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
            <div class="col-2 col-md-1">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>

            <div class="col-10 col-md-11">
                <div class="report-title-container">
                    <p>Banned Users</p>
                </div>

                <div class="banned-users">
                    <?php require 'banned_users_list.php'; ?>
                    <?php require 'modals/banned_user_details_modal.php'; ?>
                    <?php require 'modals/unban_user_modal.php'; ?>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="actions.js"></script>
</body>

</html>