<?php
// Retrieve service requests for the logged-in user

require_once __DIR__ . '/../../utilities/DatabaseHandler.php';

$reports = getAllReports();

?>

<?php if (!$reports || count($reports) === 0): ?>
    <p>There are no reports.</p>
<?php else: ?>
    <div class="container">
        <?php foreach ($reports as $report): ?>
            <div class="request-card d-flex flex-wrap justify-content-between align-items-center p-3 rounded mb-4"
                 style="background-color: #E2D4F0">

                <div class="d-flex flex-wrap align-items-center">
                    <button class="info-btn btn me-4" data-bs-toggle="modal"
                            data-bs-target="#reportDetailsModal<?=$report['id']?>">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    Report ID: <?= $report['id'] ?>
                </div>

                <div class="d-flex flex-wrap">
                    Flagged for Inappropriate Content
                </div>

                <div class="d-flex">
                    <?php if ($report['status'] === 'pending'): ?>
                        <span class="pending-badge badge me-2">PENDING</span>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    <!-- Include modal for displaying request details -->
<?php //include 'display_request_modal.php'; ?>

    <style>
        .request-card {
            background-color: #E2D4F0;
            border-radius: 20px;
            padding: 15px;
        }

        .time {
            min-width: 450px;
        }

        .info-btn {
            color: #82689A;
            border: none;
            cursor: pointer;
            font-size: 25px;
            font-weight: bold;
            padding: 0;
        }

        .info-btn:hover {
            color: #49375a;
        }

        .pending-badge {
            background-color: rgb(212, 202, 60);
        }

        .completed-badge {
            background-color: #7c9978;
        }

        .declined-badge {
            background-color: #DF8282;
        }

        .request-info {
            font-size: 18px;
            font-weight: bold;
            color: #49375a;
            display: flex;
            align-items: center;
            text-align: center;
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

        .review-btn {
            font-size: 12px;
            background-color: #82689A;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 6px 12px;
            font-weight: bold;
            border-radius: 15px;
            width: 125px;
            height: 30px;
        }

        .review-btn:hover {
            background-color: #49375a;
        }

        @media (max-width: 768px) {
            .request-info {
                font-size: 16px;
            }

            .pending-badge,
            .completed-badge,
            .declined-badge {
                padding: 6px;
            }

            .info-btn {
                padding: 2px;
            }

            .review-btn {
                margin-bottom: 2px;
            }
        }
    </style>

<?php function getAllReports(): array {
    $query = "SELECT * FROM reports
ORDER BY
CASE
WHEN status = 'pending' THEN 1
WHEN status = 'resolved' THEN 2
WHEN status = 'dismissed' THEN 3
END,
created_at DESC";

//    $query = "SELECT * FROM reports";
    $result = DatabaseHandler::make_select_query($query);
    return empty($result) ? [] : $result;

}

?>