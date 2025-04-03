<?php if (!empty($requests)): ?>
    <?php foreach ($requests as $request): ?>

        <!-- Modal for each request -->
        <div class="modal fade" id="requestModal<?= $request['request_id'] ?>" tabindex="-1">

            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Request Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p><strong>Request ID:</strong> <?= htmlspecialchars($request['request_id']) ?></p>
                        <p><strong>Service:</strong> <?= htmlspecialchars($request['service_name']) ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($request['created_at']) ?></p>

                        <!-- Display price only if it's not null -->
                        <?php if ($request['price'] !== null): ?>
                            <p><strong>Price:</strong> €<?= htmlspecialchars($request['price']) ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>

        </div>

    <?php endforeach; ?>
<?php endif; ?>