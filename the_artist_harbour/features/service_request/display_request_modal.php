<?php if (!empty($requests)): ?>
    <?php foreach ($requests as $request): ?>

        <div class="modal fade" id="requestModal<?= $request['request_id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content shadow-lg rounded-4">

                    <div class="modal-header text-white rounded-top-4">
                        <h5 class="modal-title fw-bold">Request Details</h5>
                        <button type="button" class="btn-close me-2" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body px-4 py-3">
                        <p><strong>Request ID:</strong> <?= htmlspecialchars($request['request_id']) ?></p>
                        <p><strong>Service:</strong> <?= htmlspecialchars($request['service_name']) ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($request['created_at']) ?></p>

                        <?php if ($request['min_price'] == 0): ?>
                            <!--  Displaying the Max price only if it is nonnegotiable-->
                            <p><strong>Price:</strong> €<?= htmlspecialchars($request['max_price']) ?></p>
                        <?php else: ?>
                            <!--  Displaying the price range if the price is negotiable-->
                            <p><strong>Price:</strong> €<?= htmlspecialchars($request['min_price']) ?> -
                                €<?= htmlspecialchars($request['max_price']) ?></p>
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