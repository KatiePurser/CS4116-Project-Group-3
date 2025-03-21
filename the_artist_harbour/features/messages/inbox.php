<?php
$data = require __DIR__ . '/fetch_senders.php';
$senders = $data['senders'];
$latest_message_time = $data['latest_message_time'];
$latest_sender_id = $data['latest_sender_id'];

if (!isset($_GET['sender_id'])) {
    header("Location: ?sender_id=$latest_sender_id");
    exit();
}

$sender_id = $_GET['sender_id'];
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
                    <p class="inbox-title">Inbox</p>
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
                        <p class="alert-select-conversation"><?php echo $conversation['error']; ?></p>
                    <?php else: ?>
                        <?php foreach ($conversation as $message): ?>
                            <div class="message <?php echo $message['is_sender'] ? 'sender-message' : 'receiver-message'; ?>">
                                <p><?php echo $message['text']; ?></p>
                                <small><?php echo date('d-m-Y H:i', strtotime($message['created_at'])); ?></small>

                                <!-- Report Button Form -->
                                <?php if ($message['is_sender']): ?>
                                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal"
                                        data-bs-target="#reportModal" data-message-id="<?php echo $message['id']; ?>"
                                        data-reported-id="<?php echo $message['sender_id']; ?>">
                                        <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Chat Input Box -->
                <div class="chat-input-container">
                    <form class="d-flex" id="sendMessageForm" method="post" action="send_message.php">
                        <input type="hidden" name="sender_id" value="<?php echo $receiver_id; ?>">
                        <input type="hidden" name="receiver_id" value="<?php echo $sender_id; ?>">
                        <input type="text" class="form-control me-2" name="message_text"
                            placeholder="Type your message..." required>
                        <button type="submit" class="btn">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>
                </div>


                <!-- Report Modal -->
                <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reportModalLabel">Report Message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <form method="post" action="report_message.php">
                                    <input type="hidden" name="message_id" id="reportMessageId">
                                    <input type="hidden" name="reported_id" id="reportedId">
                                    <input type="hidden" name="reporter_id" value="5">
                                    <input type="hidden" name="target_type" value="message">
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Reason for Reporting</label>
                                        <textarea class="form-control" id="reason" name="reason" rows="3"
                                            required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reporting Outcome Modal -->
                <div class="modal fade" id="reportOutcomeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Report Submitted</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div id="reportAlert" class="alert alert-success" role="alert">
                                    Your report has been submitted successfully!
                                </div>
                                <button type="button" class="btn btn-primary mt-3"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Populate Report Modal with Message Data -->
                <script>
                    var reportModal = document.getElementById('reportModal');
                    reportModal.addEventListener('show.bs.modal', function (event) {
                        var button = event.relatedTarget;
                        var messageId = button.getAttribute('data-message-id');
                        var reportedId = button.getAttribute('data-reported-id');
                        var modalMessageIdInput = reportModal.querySelector('#reportMessageId');
                        var modalReportedIdInput = reportModal.querySelector('#reportedId');
                        modalMessageIdInput.value = messageId;
                        modalReportedIdInput.value = reportedId;
                    });
                </script>

                <!-- Report Outcome Modal Script -->
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const urlParams = new URLSearchParams(window.location.search);
                        const reportStatus = urlParams.get('report');
                        const reportAlert = document.getElementById('reportAlert');
                        const reportOutcomeModal = new bootstrap.Modal(document.getElementById('reportOutcomeModal'));

                        if (reportStatus) {
                            reportAlert.classList.remove('d-none');
                            reportAlert.classList.add(reportStatus === 'success' ? 'alert-success' : 'alert-danger');
                            reportAlert.textContent = reportStatus === 'success'
                                ? 'Report submitted successfully!'
                                : 'Failed to submit report. Please try again.';
                            reportOutcomeModal.show();
                        }
                    });
                </script>
</body>

</html>