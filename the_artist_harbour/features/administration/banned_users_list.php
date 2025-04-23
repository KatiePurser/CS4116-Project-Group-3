<?php
require_once __DIR__ . '/AdminUtilities.php';
$bannedUsers = AdminUtilities::getAllBannedUsers();
?>

<?php if (!$bannedUsers || count($bannedUsers) === 0): ?>
    <p>There are no banned users.</p>
<?php else: ?>
    <div class="container">
        <?php foreach ($bannedUsers as $bannedUser): ?>
            <div class="banned-user-card d-flex flex-wrap justify-content-between align-items-center p-3 mb-4"
                 style="background-color: #E2D4F0">

                <div class="d-flex flex-wrap align-items-center">
                    <button class="user-details-btn btn me-4" onClick='openUserDetailsModal(<?= json_encode($bannedUser); ?>)'>
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <span class="banned-user-info">User ID: <?= $bannedUser['banned_user_id'] ?></span>
                </div>

                <div class="d-flex flex-wrap">
                    <?php
                    $banDate = new DateTime($bannedUser['ban_date']);
                    $formattedBanDate = $banDate->format('d/m/Y g:i');
                    ?>
                    <span class="banned-user-info"> <?= $formattedBanDate ?> </span>
                </div>

                <div  class="d-flex flex-wrap">
                    <button class="unban-btn btn btn-sm me-2" onClick='openUnbanUserModal(<?= json_encode($bannedUser); ?>)'>UNBAN</button>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
    .banned-user-card {
        background-color: #E2D4F0;
        border-radius: 50px;
        padding: 15px;
    }

    .user-details-btn {
        color: #82689A;
        border: none;
        cursor: pointer;
        font-size: 25px;
        font-weight: bold;
        padding: 0;
    }

    .banned-user-info {
        font-size: 18px;
        font-weight: bold;
        color: #49375a;
        display: flex;
        align-items: center;
        text-align: center;
    }

    .user-details-btn:hover {
        color: #49375a;
    }

    .unban-btn {
        color: white;
        background-color: #7c9978;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 6px 12px;
        font-weight: bold;
        border-radius: 15px;
        width: 100px;
        height: 30px;
    }

    .unban-btn:hover {
        color: white;
        background-color: #5f745c;
    }

    @media (max-width: 768px) {

        .user-details-btn {
            padding: 2px;
        }

    }
</style>
