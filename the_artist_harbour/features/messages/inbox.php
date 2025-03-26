<?php require 'scripts/load_current_conversation.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyApp</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="css/messaging-styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>



<body>
    <div>
        <div class="row g-0">
            <div class="col-12">
                <?php include __DIR__ . '/../../templates/header.php'; ?>
            </div>
        </div>

        <div class="row g-0 flex-grow-1 message-system-container">
            <div class="col-2 col-md-1">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>

            <div class="col-2 col-md-2 inbox-container">
                <?php include 'templates/inbox_panel.php'; ?>
            </div>

            <div class="col-8 col-md-9 conversation-container">
                <?php include 'templates/chat_panel.php'; ?>
                <?php include 'templates/report_modal.php'; ?>
                <?php include 'templates/report_outcome_modal.php'; ?>
            </div>

        </div>
    </div>

    <script src="js/handle_report.js"></script>
    <script src="js/report_outcome.js"></script>
</body>

</html>