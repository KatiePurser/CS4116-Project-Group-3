<?php
// filepath: c:\xampp\htdocs\the_artist_harbour\features\messages\inbox.php

// Include the file that fetches and groups senders
include __DIR__ . '/fetch_senders.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyApp</title>

    <link rel="stylesheet" href="../../public/css/styles.css">
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
        <div class="row">
            <div class="col-12">
                <?php include __DIR__ . '/../../templates/header.php'; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-1">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>

            <!-- Inbox Panel -->
            <div class="col-5">
                <ul id="inbox">
                    <?php foreach ($senders as $sender_id => $sender_name): ?>
                        <li class="sender-item">
                            <a href="?sender_id=<?php echo $sender_id; ?>">
                                <?php echo $sender_name; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Chat Panel -->
            <div class="col-6" id="chat-panel">
                <?php include __DIR__ . '/fetch_message_content.php'; ?>
            </div>
        </div>

    </div>

</body>

</html>