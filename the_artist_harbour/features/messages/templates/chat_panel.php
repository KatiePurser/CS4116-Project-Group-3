<div id="chat-panel">
    <div class="chat-title-container">
        <p class="chat-title"><?php echo $sender_name; ?></p>
    </div>

    <div class="chat-messages-container">
        <?php if (isset($conversation['error'])): ?>
            <p class="alert-select-conversation"><?php echo $conversation['error']; ?></p>
        <?php else: ?>

            <?php foreach ($conversation as $message): ?>
                <?php $status = $message['status'] ?>
                <div class="message <?php echo $message['is_sender'] ? 'sender-message' : 'receiver-message'; ?>">
                    <p><?php echo $message['text']; ?></p>
                    <small><?php echo date('d-m-Y H:i', strtotime($message['created_at'])); ?></small>
                    <?php if ($message['is_sender']): ?>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reportModal"
                            data-message-id="<?php echo $message['id']; ?>" data-reported-id="<?php echo $message['sender_id']; ?>">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Render the chat box only if it is an accepted message -->
    <?php if ($status === 'accepted'): ?>
        <div class="chat-input-container">
            <form class="d-flex" id="sendMessageForm" method="post" action="scripts/send_message.php">
                <input type="hidden" name="sender_id" value="<?php echo $receiver_id; ?>">
                <input type="hidden" name="receiver_id" value="<?php echo $sender_id; ?>">
                <input type="text" class="form-control me-2" name="message_text" placeholder="Type your message..."
                    required>
                <button type="submit" class="btn">
                    <i class="bi bi-send"></i>
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>