<?php
require_once __DIR__ . '/AdminUtilities.php';
$reports = AdminUtilities::getAllReports();
?>

<?php if (!$reports || count($reports) === 0): ?>
    <p>There are no reports.</p>
<?php else: ?>
    <div class="container">
        <?php foreach ($reports as $report): ?>
            <div class="report-card d-flex flex-wrap justify-content-between align-items-center p-3 mb-4"
                 style="background-color: #E2D4F0">

                <div class="d-flex flex-wrap align-items-center">
                    <button class="report-info-btn btn me-4" onClick='openReportDetailsModal(<?= htmlspecialchars(json_encode($report)); ?>, <?= json_encode($_SESSION["user_id"]); ?>)'>
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <span class="report-info">Report ID: <?= $report['id'] ?></span>
                </div>

                <div class="d-flex flex-wrap">
                    <span class="report-info">Flagged for Inappropriate Content</span>
                </div>

                <div class="d-flex">
                    <?php if ($report['status'] === 'pending'): ?>
                        <span class="pending-badge badge me-2">PENDING</span>
                    <?php elseif ($report['status'] === 'resolved'): ?>
                        <span class="resolved-badge badge me-2">RESOLVED</span>
                    <?php elseif ($report['status'] === 'dismissed'): ?>
                        <span class="dismissed-badge badge me-2">DISMISSED</span>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
    .report-card {
        background-color: #E2D4F0;
        border-radius: 50px;
        padding: 15px;
    }

    .report-info-btn {
        color: #82689A;
        border: none;
        cursor: pointer;
        font-size: 25px;
        font-weight: bold;
        padding: 0;
    }

    .report-info {
        font-size: 18px;
        font-weight: bold;
        color: #49375a;
        display: flex;
        align-items: center;
        text-align: center;
    }

    .report-info-btn:hover {
        color: #49375a;
    }

    .pending-badge {
        background-color: #fecb32;
    }

    .resolved-badge {
        background-color: #7c9978;
    }

    .dismissed-badge {
        background-color: #DF8282;
    }

    .badge {
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

    @media (max-width: 768px) {

        .pending-badge,
        .resolved-badge,
        .dismissed-badge {
            padding: 6px;
        }

        .report-info-btn {
            padding: 2px;
        }

    }
</style>
