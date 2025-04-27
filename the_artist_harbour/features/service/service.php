<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /the_artist_harbour/features/registration-login/login.php");
    exit();
}

if ($_SESSION['user_type'] == 'admin') {
    exit();
}


require_once(__DIR__ . "/../../utilities/databaseHandler.php");
require_once(__DIR__ . "/serviceDetails.php");
require_once(__DIR__ . "/insight_request_modal.php");
require_once(__DIR__ . "/service_request_modal.php");
require_once(__DIR__ . "/review_report_modal.php");
$service_id = $_GET["service_id"];
$sql = "SELECT * FROM services WHERE id=$service_id";
$result = DatabaseHandler::make_select_query($sql);
$service = $result[0];
$sql = "SELECT * FROM businesses WHERE id={$service['business_id']}";
$result = DatabaseHandler::make_select_query($sql);
$business = $result[0];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $service['name'] ?></title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/handle_insight_request.js"></script>
    <script src="js/handle_service_request.js"></script>
    <script src="js/handle_review_report.js"></script>
    <!-- <script src="js/outcome_handling.js"></script> -->

    <style>
        .information {
            margin-top: 2vh;
            margin-left: 2vw;
            margin-right: 2vw;
            margin-bottom: 3vh;
            height: fit-content;
            max-height: fit-content;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: auto;
        }

        .info-container {
            height: fit-content;
            border-radius: 2%;
            padding: 1%;
            padding-bottom: 3%;
            text-align: center;
            width: 55%;
        }

        .margin {
            height: 0;
        }

        .name-container {
            margin: auto;
            padding: 0.5%;
            margin-bottom: 2vh;
            background-color: #E2D4F0;
            border: 5px solid #82689A;
            border-radius: 0.5vw;
        }

        .business-button {
            font-size: 20px;
            text-decoration: none;
            color: black;
        }

        .business-button:hover {
            color: hotpink;
        }

        .description-and-tags {
            border-radius: 0.5vw;
            background-color: #E2D4F0;
            border-width: 0.5%;
            padding-top: 1vh;
        }

        .tags {
            color: #777;
            padding-bottom: 0.25vh;
        }

        .description-container {
            margin: auto;
            padding: 0.5vh;
            padding-left: 2vw;
            padding-right: 2vw;
            min-height: 10vw;
        }

        .image-container {
            margin-top: 3vh;
            padding: 1%;
            border: 10px solid #E2D4F0;
            width: 40%;
            height: fit-content;
            max-height: 50%;
            border-radius: 2%;
            justify-content: center;
        }

        .image {
            height: fit-content;
            max-height: 50vw;
        }

        .price-container {
            width: 50%;
        }

        .price {
            margin: auto;
            background-color: #E2D4F0;
            border-radius: 1vw;
        }

        .service_request {
            width: 40%;
        }

        .service-request-btn {
            margin-top: 2vh;
            color: white;
            background-color: #82689A;
            border-width: 5px;
            border-color: #82689A;
            border-radius: 1vw;
        }

        /* Center container with responsive padding */
        .center-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
        }


        /* Medium screens */
        @media (min-width: 768px) {
            .center-container {
                padding: 80px;
            }

            .price-and-request {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: auto;
            }
        }

        /* Large screens */
        @media (min-width: 992px) {
            .center-container {
                padding: 100px;
            }

            .service-request-btn {
                font-size: 1.75vw;
            }

            .price-and-request {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: auto;
            }
        }

        /* Extra large screens */
        @media (min-width: 1400px) {
            .center-container {
                max-width: 1320px;
                padding: 100px;
            }

            .service-request-btn {
                font-size: 1.75vw;
            }

            .price-and-request {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: auto;
            }
        }

        /* Small screens */
        @media (max-width: 768px) {
            .center-container {
                padding: 40px;
            }

            .service_request {
                width: 100%;
            }

            .service-request-btn {
                width: 100%;
                font-size: 3.5vw;
            }

            .info-container {
                width: 40%;
            }

            .image-container {
                width: 55%;
            }

            .price-container {
                width: 100%;
            }

            .price {
                width: 100%;
            }
        }

        /* Reviews Section */
        .reviews-section {
            margin-bottom: 30px;
        }

        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .sort-options {
            display: flex;
            gap: 10px;
        }

        .sort-btn {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            color: #333;
        }

        .sort-btn.active {
            background-color: #e0d8f3;
            border-color: #82689A;
            color: #49375a;
        }

        .review-item {
            padding: 20px;
            border: 1px solid #e0d8f3;
            border-radius: 12px;
            background-color: #fcfbfe;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(130, 104, 154, 0.1);
            transition: box-shadow 0.2s ease;
        }

        .review-item:hover {
            box-shadow: 0 4px 10px rgba(130, 104, 154, 0.15);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .reviewer-info {
            font-weight: bold;
            color: #4a3b5c;
        }

        .review-rating {
            color: #82689A;
        }

        .review-content {
            color: #666;
            margin: 10px 0;
        }

        .review-date {
            color: #999;
            font-size: 0.9em;
            text-align: right;
        }

        .replied {
            font-weight: bold;
            color: #4a3b5c;
        }

        .reply-text {
            color: #666;
            margin: 10px 0;
        }

        .service-reviewed-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #e0d8f3;
            padding-bottom: 10px;
        }

        .service-reviewed-header h4 {
            color: #49375a;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .review-actions {
            display: flex;
            gap: 10px;
        }

        .flag-review-btn {
            color: #dc3545;
            border-color: #dc3545;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .flag-review-btn:hover {
            background-color: #dc3545;
            color: white;
        }

        .insight-request-btn {
            color: #82689A;
            border-color: #82689A;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .insight-request-btn:hover {
            background-color: #82689A;
            color: white;
        }

        .btn-outline-purple {
            color: #82689A;
            border-color: #82689A;
        }

        .btn-outline-purple:hover {
            background-color: #82689A;
            color: white;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            display: block;
            padding: 5px 10px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #e0d8f3;
        }

        .pagination a.active {
            background-color: #82689A;
            color: white;
            border-color: #70578c;
        }

        .modal-header,
        .submit-btn {
            background-color: #82689A;
        }

        .submit-btn:hover {
            background-color: #5b496d;
        }

        .modal-title {
            padding: 10px;
        }
    </style>
</head>

<body style="padding-top: 73.6px;">
    <div>
        <?php include __DIR__ . '/../../templates/header.php'; ?>
    </div>

    <div class="information">
        <div class="info-container justify-content-center">
            <div class="name-container">
                <h1 class="name"><?php echo $service['name'] ?></h1>
                <?php
                $url = "../business/profile.php?business_id=" . $business['id'];
                echo '<a class="business-button" href=' . $url . '> from ' . $business['display_name'] . '</a>'; ?>
            </div>
            <div class="description-and-tags">
                <div class="description-container">
                    <h5 class="description-title">DESCRIPTION</h5>
                    <h5 class="description"><?php echo $service['description'] ?></h5>
                </div>
                <div class="tags-container">
                    <?php
                    $tags_string = "";
                    if ($service['tags'] != NULL) {
                        $tags_string == "Tags: ";
                        $tags = explode(",", $service['tags'], 25);
                        $i = 0;
                        while ($i < count($tags)) {
                            $tags_string .= $tags[$i];
                            if ($i != count($tags) - 1) {
                                $tags_string .= ", ";
                            }
                            $i++;
                        }
                    } else {
                        $tags_string = "No Tags";
                    } ?>
                    <p class="tags"><?php echo "Tags: " . $tags_string ?></p>
                </div>
            </div>
            <div class="price-and-request">
                <div class="price-container">
                    <?php
                    if ($service['min_price'] == NULL) { ?>
                        <h3 class="price"> <?php echo "€" . $service['max_price']; ?> </h3>
                    <?php } else { ?>
                        <h3 class="price"> <?php echo "€" . $service['min_price'] . " - €" . $service['max_price']; ?></h3>
                    <?php }
                    ?>
                </div>
                <div class="service_request">
                    <?php if ($_SESSION['user_type'] == 'customer') {
                        if ($service['min_price'] == NULL) {
                            $min_price = '0';
                        } else {
                            $min_price = $service['min_price'];
                        } ?>
                        <button type="button" class="btn service-request-btn p-0" data-bs-toggle="modal"
                            data-bs-target="#serviceRequestModal" data-price-min="<?php echo $min_price ?>"
                            data-price-max="<?php echo $service['max_price'] ?>"
                            data-service-id="<?php echo $service['id'] ?>">
                            Request Service
                        </button>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="image-container">
            <?php
            if (!empty($service['image'])) { ?>
                <img src="../business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top image"
                    alt="Service Image">
            <?php } else { ?>
                <img src="../../public/images/default.png" class="card-img-top image" alt="Default Image">
            <?php }
            ?>
        </div>
    </div>

    <!-- Reviews -->
    <?php
    $reviews_per_page = 5;
    $review_page = isset($_GET['review_page']) ? (int) $_GET['review_page'] : 1;
    $review_offset = ($review_page - 1) * $reviews_per_page;

    $sql = "SELECT * FROM reviews WHERE service_id=$service_id";
    $num_reviews = count(DatabaseHandler::make_select_query($sql));
    $total_review_pages = ceil($num_reviews / $reviews_per_page);

    $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

    if ($num_reviews > 0) {
        if ($sort_by == "newest") {
            $sql .= " ORDER BY created_at DESC";
        } else if ($sort_by == "highest") {
            $sql .= " ORDER BY rating DESC";
        } else if ($sort_by == "lowest") {
            $sql .= " ORDER BY rating ASC";
        }
        $sql .= " LIMIT $review_offset, $reviews_per_page";
    }
    $reviews = DatabaseHandler::make_select_query($sql);
    ?>

    <div class="center-container">
        <div class="reviews-section">
            <div class="reviews-header">
                <?php if ($num_reviews > 0) { ?>
                    <h2> REVIEWS </h2>
                    <div class="sort-options">
                        <a href="?service_id=<?php echo $service_id; ?>&sort=newest"
                            class="sort-btn <?php echo $sort_by === 'newest' ? 'active' : ''; ?>">
                            Newest
                        </a>
                        <a href="?service_id=<?php echo $service_id; ?>&sort=highest"
                            class="sort-btn <?php echo $sort_by === 'highest' ? 'active' : ''; ?>">
                            Highest Rating
                        </a>
                        <a href="?service_id=<?php echo $service_id; ?>&sort=lowest"
                            class="sort-btn <?php echo $sort_by === 'lowest' ? 'active' : ''; ?>">
                            Lowest Rating
                        </a>
                    </div>
                <?php } else { ?>
                    <h2>NOT YET REVIEWED</h2>
                <?php } ?>
            </div>

            <?php if (count($reviews) > 0) {
                foreach ($reviews as $review) {
                    $id = $review['id'];
                    $sql = "SELECT * FROM review_replies WHERE review_id=$id";
                    $reply_exists = DatabaseHandler::make_select_query($sql);
                    ?>
                    <div class="review-item">
                        <div class="service-reviewed-header">
                            <div class="reviewer-info">
                                <?php echo htmlspecialchars(ServiceDetails::getReviewer($review['reviewer_id'])); ?>
                            </div>

                            <div class="review-actions">
                                <?php if ($_SESSION['user_id'] != $review['reviewer_id']) { ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger flag-review-btn"
                                        data-bs-toggle="modal" data-bs-target="#reviewReportModal"
                                        data-review-id="<?php echo $review['id']; ?>"
                                        data-reported-id="<?php echo $review['reviewer_id']; ?>"
                                        data-service-id="<?php echo $service_id; ?>"
                                        data-review-content="<?php echo htmlspecialchars($review['text']); ?>">
                                        <i class="bi bi-flag"></i> Flag
                                    </button>
                                <?php } ?>

                                <!-- Insight Request button for customers only -->
                                <?php if ($_SESSION['user_type'] === 'customer' && $_SESSION['user_id'] != $review['reviewer_id']) { ?>
                                    <button type="button" class="btn btn-sm btn-outline-purple insight-request-btn"
                                        data-bs-toggle="modal" data-bs-target="#insightRequestModal"
                                        data-service-id="<?php echo $review['service_id']; ?>"
                                        data-receiver-id="<?php echo $review['reviewer_id'];
                                        ; ?>">
                                        <i class="bi bi-lightbulb"></i> Request Insight
                                    </button>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="review-header">
                            <div class="review-rating">
                                <?php
                                $rating = $review['rating'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<i class="bi bi-star-fill"></i>';
                                    } elseif ($i - 0.5 <= $rating) {
                                        echo '<i class="bi bi-star-half"></i>';
                                    } else {
                                        echo '<i class="bi bi-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="review-content">
                            <?php echo htmlspecialchars($review['text']); ?>
                        </div>
                        <div class="review-date">
                            <em>Reviewed on: <?php echo date("F j, Y", strtotime($review['created_at'])); ?></em>
                        </div>
                        <div class="review-reply">
                            <!-- Review Reply Button for Businesses only -->
                            <?php if ($_SESSION['user_type'] === 'business' && $reply_exists == NULL) { ?>
                                <form id="responseForm" method="POST" action="../review/submit_review_reply.php">
                                    <input type="hidden" name="review_id" id="reviewId" value="<?php echo $review['id'] ?>">
                                    <input type="hidden" name="page" id="page" value="service">
                                    <input type="hidden" name="service_id" id="service_id" value="<?php echo $service_id ?>">

                                    <div class="mb-4">
                                        <label for="reviewResponseText" class="form-label fw-semibold">Your Response</label>
                                        <textarea class="form-control rounded-3 border" id="reviewResponseText"
                                            name="review_response_text" rows="4" placeholder="Type your response here..."
                                            required></textarea>
                                    </div>

                                    <div class="modal-footer d-flex justify-content-between border-0 px-0">
                                        <button type="submit" class="submit-btn btn text-white px-4">Submit Response</button>
                                    </div>
                                </form>
                            <?php } else if ($reply_exists) { ?>
                                    <div class="review-reply-content">
                                        <div class="replied">
                                        <?php echo htmlspecialchars("Reply from Business:"); ?>
                                        </div>
                                        <div class="reply-text">
                                        <?php echo htmlspecialchars($reply_exists[0]['text']); ?>
                                        </div>
                                        <div class="review-date">
                                            <em>Replied on:
                                            <?php echo date("F j, Y", strtotime($reply_exists[0]['created_at'])); ?></em>
                                        </div>
                                    </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <!-- Pagination for Reviews -->
                <?php if ($total_review_pages > 1): ?>
                    <div class="pagination-container">
                        <ul class="pagination">
                            <?php if ($review_page > 1): ?>
                                <li><a
                                        href="?service_id=<?php echo $service_id; ?>&review_page=<?php echo $review_page - 1; ?>&sort=<?php echo $sort_by; ?>">&laquo;
                                        Previous</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_review_pages; $i++): ?>
                                <li>
                                    <a href="?service_id=<?php echo $service_id; ?>&review_page=<?php echo $i; ?>&sort=<?php echo $sort_by; ?>"
                                        <?php echo $i === $review_page ? 'class="active"' : ''; ?>>
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($review_page < $total_review_pages): ?>
                                <li><a
                                        href="?service_id=<?php echo $service_id; ?>&review_page=<?php echo $review_page + 1; ?>&sort=<?php echo $sort_by; ?>">Next
                                        &raquo;</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php } ?>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const actionStatus = urlParams.get('outcome');
            const action = urlParams.get('action')

            if (action == '0') {
                const reviewReportOutcomeModal = new bootstrap.Modal(document.getElementById('reviewReportOutcomeModal'));
                if (actionStatus) {
                    const actionAlert = document.getElementById('actionFeedbackReview');
                    actionAlert.classList.remove('d-none');
                    actionAlert.classList.add(actionStatus === 'success' ? 'alert-success' : 'alert-danger');
                    actionAlert.textContent = actionStatus === 'success'
                        ? 'Report submitted successfully!'
                        : 'Failed to submit report. Please try again.';
                    reviewReportOutcomeModal.show();
                }
            } else if (action == '1') {
                const insightRequestOutcomeModal = new bootstrap.Modal(document.getElementById('insightRequestOutcomeModal'));
                if (actionStatus) {
                    const actionAlert = document.getElementById('actionFeedbackInsight');
                    actionAlert.classList.remove('d-none');
                    actionAlert.classList.add(actionStatus === 'success' ? 'alert-success' : 'alert-danger');
                    actionAlert.textContent = actionStatus === 'success'
                        ? 'Insight request sent successfully!'
                        : 'Failed to send insight request. Please try again.';
                    insightRequestOutcomeModal.show();
                }
            } else if (action == '2') {
                const serviceRequestOutcomeModal = new bootstrap.Modal(document.getElementById('serviceRequestOutcomeModal'));
                if (actionStatus) {
                    const actionAlert = document.getElementById('actionFeedbackService');
                    actionAlert.classList.remove('d-none');
                    actionAlert.classList.add(actionStatus === 'success' ? 'alert-success' : 'alert-danger');
                    actionAlert.textContent = actionStatus === 'success'
                        ? 'Service request sent successfully!'
                        : 'Failed to send service request. Please try again.';
                    serviceRequestOutcomeModal.show();
                }
            }
        });
    </script>
</body>

</html>