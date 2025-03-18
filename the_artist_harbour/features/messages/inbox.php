<?php
require_once __DIR__ . '/fetch_senders.php';
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

        .inbox {
            background-color: #DDD2E5;
        }

        .inbox-title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            text-align: center;
            border-bottom: 1px solid #49375a;
        }

        .inbox-title {
            padding: 10px;
            font-weight: bold;
            font-size: 1.5rem;
            color: #49375a;
        }

        .container-fluid {
            background-color: #DDD2E5;
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
            <!-- Sidebar -->
            <div class="col-1">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>

            <!-- Inbox Panel -->
            <div class="col-3 inbox">

                <div class="inbox-title-container">
                    <p class="inbox-title">Messages</p>
                </div>

                <ul id="inbox">
                    <?php if (!empty($senders)): ?>
                        <?php foreach ($senders as $sender_id => $sender_name): ?>
                            <li class="sender-item">
                                <a href="?sender_id=<?php echo $sender_id; ?>">
                                    <?php echo $sender_name; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Inbox is Empty!</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Chat Panel -->
            <div class="col-8" id="chat-panel">
                <?php require_once __DIR__ . '/fetch_message_content.php'; ?>
            </div>
        </div>

    </div>

</body>

</html>