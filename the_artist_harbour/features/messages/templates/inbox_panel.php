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


                                <!-- RENDERING ACCEPT OR DECLINE FOR INSIGHT REQUEST -->
                                <?php if ($conversation['latest_message']['status'] === 'pending' && $conversation['latest_message']['sender_id'] !== $_SESSION['user_id']): ?>
                                    <div class="user-action-container">
                                        <span><?php echo $conversation['other_user']; ?></span>

                                        <form method="post" action="scripts/accept_message_request.php" class="insight-action">
                                            <input type="hidden" name="conversation_id"
                                                value="<?php echo $conversation['conversation_id']; ?>">

                                            <button type="submit" name="action" value="accept" class="accept-btn">ACCEPT</button>
                                            <button type="submit" name="action" value="decline" class="decline-btn">DECLINE</button>
                                        </form>
                                    </div>
                                <?php elseif ($conversation['latest_message']['status'] === 'pending' && $conversation['latest_message']['sender_id'] === $_SESSION['user_id']): ?>
                                    <div class="user-action-container">
                                        <span><?php echo $conversation['other_user']; ?></span>
                                        <span class="pending-badge badge me-2">REQUEST PENDING</span>
                                    </div>

                                <?php else: ?>
                                    <div
                                        style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                                        <span><?php echo $conversation['other_user']; ?></span>
                                        <span
                                            class="message-time"><?php echo date('d-m-Y H:i', strtotime($conversation['latest_message']['created_at'])); ?></span>
                                    </div>

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
<style>
    .btn-body {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .message-time {
        font-size: 0.75rem;
        color: #666;
        margin-top: 4px;
    }

    .pending-badge {
        background-color: #e69419;
        padding: 7px 10px;
        font-size: 0.8rem;
        border: none;
        border-radius: 4px;
        color: white;
        margin-top: 8px;
        font-weight: normal;
    }

    .user-action-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .insight-action {
        display: flex;
        gap: 8px;
        margin-top: 8px;
    }

    .insight-action button {
        padding: 4px 10px;
        font-size: 0.8rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        transition: background-color 0.3s ease;
    }

    .insight-action .accept-btn {
        background-color: #7c9978;
    }

    .insight-action .accept-btn:hover {
        background-color: #5f745c;
    }

    .insight-action .decline-btn {
        background-color: #DF8282;
    }

    .insight-action .decline-btn:hover {
        background-color: #975959;
    }
</style>