<!-- Inbox Panel -->
<div>
    <div class="inbox-title-container">
        <p class="inbox-title">Inbox</p>
    </div>

    <div class="inbox-item-container">
        <!-- List of Conversations by Sender -->
        <ul id="inbox">
            <?php if (!empty($senders)): ?>
                <?php foreach ($senders as $id => $name): ?>
                    <li class="sender-item">
                        <a href="?sender_id=<?php echo $id; ?>" class="btn">
                            <div class="btn-body">
                                <div><span><?php echo $name; ?></span></div>

                                <div>
                                    <!-- RENDERING ACCEPT OR DECLINE FOR INSIGHT REQUEST -->
                                    <?php if (isset($latest_messages[$id]) && $latest_messages[$id]['status'] === 'pending'): ?>
                                        <span>
                                            <form method="post" action="scripts/insight_request.php"
                                                class="d-inline insight-action">
                                                <input type="hidden" name="message_id"
                                                    value="<?php echo $latest_messages[$id]['message_id']; ?>">
                                                <input type="hidden" name="sender_id" value="<?php echo $id; ?>">
                                                <button type="submit" name="action" value="accept"
                                                    class="btn btn-success btn-sm">Accept</button>
                                                <button type="submit" name="action" value="decline"
                                                    class="btn btn-danger btn-sm">Decline</button>
                                            </form>
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="message-time"><?php echo date('d-m-Y H:i', strtotime($latest_messages[$id]['time'])); ?></span>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Inbox is Empty!</li>
            <?php endif; ?>
        </ul>
    </div>

</div>