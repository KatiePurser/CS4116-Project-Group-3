<!-- Inbox Panel -->
<div>
    <div class="inbox-title-container">
        <span class="inbox-title">Inbox</span>
    </div>

    <div class="inbox-item-container">
        <!-- List of Conversations by Sender -->
        <ul id="inbox">
            <?php if (!empty($conversations)): ?>
                <?php foreach ($conversations as $conversation): ?>

                    <li class="sender-item">
                        <a href="?conversation_id=<?php echo $conversation['conversation_id']; ?>" class="btn">
                            <div class="btn-body">
                                <div><span><?php echo $conversation['other_user']; ?></span></div>

                                <!-- RENDERING ACCEPT OR DECLINE FOR INSIGHT REQUEST -->
                                <?php if ($conversation['status'] === 'pending'): ?>

                                    <form method="post" action="scripts/accept_message_request.php" class="d-inline insight-action">
                                        <input type="hidden" name="conversation_id"
                                            value="<?php echo $conversation['conversation_id']; ?>">
                                        <button type="submit" name="action" value="accept"
                                            class="btn btn-success btn-sm">Accept</button>
                                        <button type="submit" name="action" value="decline"
                                            class="btn btn-danger btn-sm">Decline</button>
                                    </form>

                                <?php else: ?>
                                    <span
                                        class="message-time"><?php echo date('d-m-Y H:i', strtotime($conversation['latest_message_time'])); ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </li>

                <?php endforeach; ?>
            <?php else: ?>
                <li class="p-4">Inbox is Empty!</li>
            <?php endif; ?>
        </ul>
    </div>

</div>