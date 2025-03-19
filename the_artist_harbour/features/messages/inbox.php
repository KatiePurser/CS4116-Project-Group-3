<?php
$data = require __DIR__ . '/fetch_senders.php';
$senders = $data['senders'];
$latest_message_time = $data['latest_message_time'];
$latest_sender_id = $data['latest_sender_id'];

$sender_id = isset($_GET['sender_id']) ? $_GET['sender_id'] : $latest_sender_id;
$sender_name = isset($senders[$sender_id]) ? $senders[$sender_id] : 'Sender Name';

$conversation = require __DIR__ . '/fetch_message_content.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyApp</title>

    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="../../public/css/messaging-styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container-fluid">
        <!-- Navigation Header -->
        <div class="row g-0">
            <div class="col-12">
                <?php include __DIR__ . '/../../templates/header.php'; ?>
            </div>
        </div>

        <div class="row g-0 flex-grow-1">
            <!-- Navigation Sidebar -->
            <div class="col-2 col-md-1">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>

            <!-- Inbox Panel -->
            <div class="col-3 col-md-3 inbox">
                <div class="inbox-title-container">
                    <p class="inbox-title">Messages</p>
                </div>

                <!-- List of Conversations by Sender -->
                <ul id="inbox">
                    <?php if (!empty($senders)): ?>
                        <?php foreach ($senders as $id => $name): ?>
                            <li class="sender-item">
                                <a href="?sender_id=<?php echo $id; ?>">
                                    <button class="btn">
                                        <div class="btn-body">
                                            <span><?php echo $name; ?></span>
                                            <span
                                                class="message-time"><?php echo date('d-m-Y H:i', strtotime($latest_message_time[$id])); ?></span>
                                        </div>
                                    </button>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Inbox is Empty!</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Chat Panel -->
            <div class="col-7 col-md-8 d-flex flex-column" id="chat-panel">
                <div class="chat-title-container">
                    <p class="chat-title"><?php echo $sender_name; ?></p>
                </div>

                <!-- Conversation -->
                <div class="chat-messages-container">
                    <?php if (isset($conversation['error'])): ?>
                        <p><?php echo $conversation['error']; ?></p>
                    <?php else: ?>
                        <?php foreach ($conversation as $message): ?>
                            <div class="message <?php echo $message['is_sender'] ? 'sender-message' : 'receiver-message'; ?>">
                                <p><?php echo $message['text']; ?></p>
                                <small><?php echo date('d-m-Y H:i', strtotime($message['created_at'])); ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Chat Input Box -->
                <div class="chat-input-container">
                    <form class="d-flex">
                        <input type="text" class="form-control me-2" placeholder="Type your message...">
                        <button type="submit" class="btn">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>