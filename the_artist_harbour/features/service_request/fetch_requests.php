<?php
// Retrieve service requests for the logged-in user
$requests = ServiceRequestHandler::retrieveRequests($_SESSION['user_id']);
?>

<?php if (!$requests || count($requests) === 0): ?>
    <p>No service requests found.</p>
<?php else: ?>
    <div class="requests-container">
        <div class="request-container">
            <?php foreach ($requests as $request): ?>
                <div class="request-card d-flex flex-wrap justify-content-between align-items-center p-3  mb-4">

                    <?php
                    // Format the request creation date
                    $date = new DateTime($request['created_at']);
                    $formattedDate = $date->format('d/m/Y g:i');
                    ?>

                    <div class="d-flex flex-wrap">
                        <!-- Info button to open request details modal -->
                        <button class="info-btn btn me-4" data-bs-toggle="modal"
                            data-bs-target="#requestModal<?= $request['request_id'] ?>">
                            <i class="bi bi-info-circle"></i>
                        </button>

                        <!-- Display request creation date and service name -->
                        <span class="request-info time-stamp"> <?= $formattedDate ?> </span>
                        <?php if ($request['user_type'] === 'business'): ?>
                            <span class="request-info"> <?= htmlspecialchars($request['customer']) ?> </span>
                        <?php else: ?>
                            <span class="request-info"> <?= htmlspecialchars($request['service_name']) ?> </span>
                        <?php endif; ?>

                    </div>

                    <div class="d-flex flex-wrap">
                        <?php if ($request['user_type'] === 'customer'): ?>
                            <!-- Display status badges and action buttons for customers -->
                            <?php if ($request['status'] === 'pending'): ?>
                                <span class="pending-badge badge me-2">PENDING</span>
                            <?php elseif ($request['status'] === 'completed'): ?>

                                <?php if ($request['reviewed'] === 0): ?>
                                    <button class="review-btn btn btn-primary btn-sm me-2" data-bs-toggle="modal"
                                        data-bs-target="#reviewModal" data-service-id="<?= htmlspecialchars($request['service_id']) ?>"
                                        data-request-id="<?= htmlspecialchars($request['request_id']) ?>">LEAVE A REVIEW</button>

                                    <span class="completed-badge badge me-2">COMPLETED</span>
                                <?php else: ?>
                                    <span class="completed-badge badge me-2">COMPLETED</span>
                                <?php endif; ?>

                            <?php elseif ($request['status'] === 'declined'): ?>
                                <span class="declined-badge badge me-2">DECLINED</span>
                            <?php endif; ?>

                        <?php elseif ($request['user_type'] === 'business'): ?>
                            <!-- Display status badges and action buttons for businesses -->
                            <?php if ($request['status'] === 'pending'): ?>
                                <button class="accept-btn btn btn-sm me-2" data-bs-toggle="modal" data-bs-target="#acceptRequestModal"
                                    data-request-id="<?= htmlspecialchars($request['request_id']) ?>"
                                    data-service-id="<?= htmlspecialchars($request['service_id']) ?>"
                                    data-created-at="<?= htmlspecialchars($request['created_at']) ?>"
                                    data-service-name="<?= htmlspecialchars($request['service_name']) ?>"
                                    data-min-price="<?= htmlspecialchars($request['min_price']) ?>"
                                    data-max-price="<?= htmlspecialchars($request['max_price']) ?>">
                                    ACCEPT
                                </button>

                                <button class="decline-btn btn btn-sm me-2" data-bs-toggle="modal" data-bs-target="#declineRequestModal"
                                    data-decline-request-id="<?= htmlspecialchars($request['request_id']) ?>"
                                    data-decline-service-id="<?= htmlspecialchars($request['service_id']) ?>"
                                    data-decline-created-at="<?= htmlspecialchars($request['created_at']) ?>"
                                    data-decline-service-name="<?= htmlspecialchars($request['service_name']) ?>">
                                    DECLINE
                                </button>

                            <?php elseif ($request['status'] === 'completed'): ?>
                                <span class="completed-badge badge me-2">COMPLETED</span>
                            <?php elseif ($request['status'] === 'declined'): ?>
                                <span class="declined-badge badge me-2">DECLINED</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>

<?php include_once 'accept_request_modal.php'; ?>
<?php include_once 'decline_request_modal.php'; ?>

<style>
    .time-stamp {
        min-width: 550px;
    }

    .requests-container {
        display: flex;
        justify-content: center;
    }

    .request-container {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 73.6px);
        overflow: hidden;
        min-width: 80%;
        max-width: 80%;
    }

    .request-card {
        background-color: #E2D4F0;
        border-radius: 50px;
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
        color: #c295ec;
    }

    .pending-badge {
        background-color: rgb(230, 182, 25);
    }

    .completed-badge {
        background-color: #7c9978;
    }

    .declined-badge {
        background-color: #DF8282;
    }

    .accept-btn {
        color: white;
        background-color: #7c9978;
    }

    .accept-btn:hover {
        color: white;
        background-color: #5f745c;
    }

    .decline-btn {
        color: white;
        background-color: #DF8282;
        border: none;
    }

    .decline-btn:hover {
        color: white;
        background-color: #975959;
    }

    .accept-btn,
    .decline-btn {
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

        font-weight: bold;
        border-radius: 15px;
        width: 100px;
        height: 30px;
    }

    .review-btn,
    .reviewed-btn {
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

    .review-btn:hover,
    .reviewed-btn:hover {
        background-color: rgb(88, 66, 109);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('acceptRequestModal');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const requestId = button.getAttribute('data-request-id');
            const serviceId = button.getAttribute('data-service-id');
            const createdAt = button.getAttribute('data-created-at');
            const serviceName = button.getAttribute('data-service-name');
            const minPrice = parseInt(button.getAttribute('data-min-price'));
            const maxPrice = parseInt(button.getAttribute('data-max-price'));

            // Display data in modal
            document.getElementById('request-id-display').textContent = requestId;
            document.getElementById('service-id-display').textContent = serviceId;
            document.getElementById('created-at-display').textContent = new Date(createdAt).toLocaleString();
            document.getElementById('service-name-display').textContent = serviceName;
            document.getElementById('price-display').textContent = maxPrice;
            document.getElementById('price-display-range').textContent = '€' + minPrice + ' - €' + maxPrice;

            // Hidden form fields
            document.getElementById('request-id').value = requestId;
            document.getElementById('service-id').value = serviceId;
            document.getElementById('created-at').value = new Date(createdAt).toLocaleString();
            document.getElementById('service-name').value = serviceName;
            document.getElementById('min-price').value = minPrice;
            document.getElementById('max-price').value = maxPrice;

            // Show or hide price input field
            const priceDisplayContainer = document.getElementById('price-display-container');
            const priceDisplayRangeContainer = document.getElementById('price-display-range-container');
            const priceInputContainer = document.getElementById('price-input-container');
            const customPriceInput = document.getElementById('custom-price');
            const errorDiv = document.getElementById('price-error');
            customPriceInput.min = minPrice;
            customPriceInput.max = maxPrice;

            customPriceInput.addEventListener('input', function () {
                const value = parseInt(customPriceInput.value, 10);

                if (isNaN(value) || value < minPrice || value > maxPrice) {
                    errorDiv.style.display = 'block';
                    errorDiv.textContent = `Price must be between €${minPrice} and €${maxPrice}.`;
                } else {
                    errorDiv.style.display = 'none';
                }
            });

            if (minPrice !== 0) {
                priceInputContainer.style.display = 'block';
                customPriceInput.required = true;

                // Hide price display
                priceDisplayContainer.style.display = 'none';

                // Show price range display
                priceDisplayRangeContainer.style.display = 'block';
            } else {
                priceInputContainer.style.display = 'none';
                customPriceInput.required = false;

                // Show price display
                priceDisplayContainer.style.display = 'block';

                // Hide price range display
                priceDisplayRangeContainer.style.display = 'none';
            }
        });
    });



    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('declineRequestModal');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const requestId = button.getAttribute('data-decline-request-id');
            const serviceId = button.getAttribute('data-decline-service-id');
            const createdAt = button.getAttribute('data-decline-created-at');
            const serviceName = button.getAttribute('data-decline-service-name');

            document.getElementById('decline-request-id-display').textContent = requestId;
            document.getElementById('decline-service-id-display').textContent = serviceId;
            document.getElementById('decline-created-at-display').textContent = new Date(createdAt).toLocaleString();
            document.getElementById('decline-service-name-display').textContent = serviceName;

            document.getElementById('decline-request-id').value = requestId;
            document.getElementById('decline-service-id').value = serviceId;
            document.getElementById('decline-created-at').value = new Date(createdAt).toLocaleString();
            document.getElementById('decline-service-name').value = serviceName;

        });
    });
</script>