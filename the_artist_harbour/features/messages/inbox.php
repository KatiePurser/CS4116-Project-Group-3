<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /the_artist_harbour/features/registration-login/login.php");
    exit();
}

require_once __DIR__ . '/../../utilities/validateUser.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Artist Harbour</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="../../public/scss/style.scss">
    <link rel="stylesheet" href="css/messaging-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        div {
            padding: 0 !important;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-12">
                <?php require_once __DIR__ . '/../../templates/header.php'; ?>
            </div>
        </div>
        <div class="row g-0 flex-grow-1 message-system-container">
            <div class="col-md-1 d-none d-md-block">
                <?php require_once __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>

            <div class="col-4 col-md-2 inbox-container">
                <?php require_once __DIR__ . '/scripts/fetch_conversations.php'; ?>
                <?php require_once __DIR__ . '/templates/inbox_panel.php'; ?>
            </div>

            <div class="col-8 col-md-9 conversation-container">
                <?php require_once __DIR__ . '/templates/report_modal.php'; ?>
                <?php require_once __DIR__ . '/templates/report_outcome_modal.php'; ?>
                <?php require_once __DIR__ . '/templates/conversation_panel.php'; ?>
            </div>
        </div>


    </div>

    <script src="handle_report.js"></script>
    <script src="report_outcome.js"></script>
</body>

</html>