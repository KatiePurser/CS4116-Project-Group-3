<?php if (!empty($requests)): ?>
    <!-- Loop through each request and create a modal for it -->
    <?php foreach ($requests as $request): ?>

        <!-- Modal for displaying request details -->
        <div class="modal fade" id="requestModal<?= $request['request_id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content shadow-lg rounded-4">

                    <div class="modal-header text-white rounded-top-4">
                        <h5 class="modal-title fw-bold">Request Details</h5>
                        <button type="button" class="btn-close me-2" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Displaying request information -->
                    <div class="modal-body px-4 py-3">
                        <p><strong>Business:</strong> <?= $request['display_name'] ?></p>
                        <p><strong>Service:</strong> <?= $request['service_name'] ?></p>
                        <p><strong>Customer:</strong> <?= $request['customer'] ?></p>
                        <p><strong>Date:</strong> <?= $request['created_at'] ?></p>

                        <!-- Conditional display of price -->
                        <?php if ($request['min_price'] == 0): ?>
                            <!-- If min_price is 0, display only the max_price (fixed price) -->
                            <p><strong>Price:</strong> €<?= $request['max_price'] ?></p>
                        <?php else: ?>
                            <!-- Otherwise, display a price range (negotiable price) -->
                            <p><strong>Price:</strong> €<?= $request['min_price'] ?> -
                                €<?= $request['max_price'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>