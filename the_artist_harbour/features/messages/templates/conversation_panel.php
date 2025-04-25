<?php
$conversation_data = require_once __DIR__ . '/../scripts/fetch_current_conversation.php';

$messages = $conversation_data['messages'];
$other_user_name = $conversation_data['other_user_name'];
$conversation_id = $conversation_data['conversation_id'];
?>

<div id="chat-panel">
    <div class="chat-title-container">
        <span class="chat-title"><?= $other_user_name ?? 'Conversation' ?></span>
    </div>

    <div class="chat-messages-container">
        <?php if ($messages == null): ?>
            <p class="no-conversation-alert">You have no conversations!</p>
        <?php else: ?>
            <?php foreach ($messages as $message): ?>
                <?php $status = $message['status']; ?>

                <!--  Ensures that the logged in user owns the messages (i.e. sent the message in question) -->
                <?php if ($user_id === $message['sender_id']): ?>
                    <div class="user-message">
                        <?php echo $message['text']; ?>

                        <div class="message-time" style="font-size: 0.75rem; color: #666; margin-top: 4px;">
                            <?php echo date('d-m-Y H:i', strtotime($message['created_at'])); ?>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="other-user-message">
                        <?php echo $message['text']; ?>

                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reportModal"
                            data-message-id="<?php echo $message['id']; ?>"
                            data-reported-user-id="<?php echo $message['sender_id']; ?>"
                            data-reporter-user-id="<?php echo $_SESSION['user_id']; ?>"
                            data-message-content="<?php echo $message['text']; ?>"
                            data-conversation-id="<?php echo $conversation_id; ?>">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>

                        <div class="message-time" style="font-size: 0.75rem; color: #666; margin-top: 4px;">
                            <?php echo date('d-m-Y H:i', strtotime($message['created_at'])); ?>
                        </div>
                    </div>

                <?php endif; ?>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if ($status === 'accepted'): ?>
        <div class="chat-input-container">
            <form class="d-flex text-box" id="sendMessageForm" method="post" action="scripts/send_message.php">
                <input type="hidden" name="conversation_id" value="<?php echo $conversation_id ?>">
                <input type="text" class="form-control me-3" name="message_text" placeholder="Type your message..."
                    required>
                <button type="submit" class="btn me-4">
                    <i class="bi bi-send"></i>
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<style>
    .message-time {
        font-size: 0.75rem;
        color: #666;
        margin-top: 4px;
    }
</style>