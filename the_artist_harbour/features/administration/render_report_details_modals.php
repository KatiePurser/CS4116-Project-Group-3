<?php if (!empty($reports)): ?>
<?php foreach ($reports as $report): ?>
<div class="modal fade" id="reportDetailsModal<?=$report['id']?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Report ID:</strong> <?=htmlspecialchars($report['id']) ?></p>
                <p><strong>Type:</strong> <?=htmlspecialchars($report['target_type']) ?></p>
                <p><strong>Reason:</strong> <?=htmlspecialchars($report['reason'])?></p>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary">Ban</button>
                <button type="button" class="btn btn-secondary">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?php
    function banUser(int $user_id, int $banned_by, string $ban_reason): bool {
        $query = "INSERT INTO banned_users (banned_user_id, banned_by, ban_reason) VALUES ($user_id, $banned_by, '$ban_reason')";
        $result = DatabaseHandler::make_modify_query($query);

        return $result === 1;
    }
?>
<style>
    .modal-content {
        background-color: #82689A;
        color: white;
    }

    .btn-primary {
        background-color: #49375a;
        border-color: #49375a;
    }

    .btn-primary:hover {
        background-color: rgb(59, 44, 73);
    }

    .btn-secondary {
        background-color: #b5a9bf;
        border-color: #b5a9bf;
    }

    .btn-secondary:hover {
        background-color: #a395af;
    }
</style>
