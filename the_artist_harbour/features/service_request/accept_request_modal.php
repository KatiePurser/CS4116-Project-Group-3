<div class="modal fade" id="acceptRequestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acceptRequestModalLabel">Confirm Accept Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="accept_request.php">
                <div class="modal-body">
                    <p><strong>Request ID:</strong> <span id="request-id-display"></span></p>
                    <p><strong>Service ID:</strong> <span id="service-id-display"></span></p>
                    <p><strong>Created At:</strong> <span id="created-at-display"></span></p>
                    <p><strong>Service Name:</strong> <span id="service-name-display"></span></p>
                    <p id="price-display-container"><strong>Price:</strong> <span id="price-display"></span></p>


                    <div id="price-input-container" class="mt-3" style="display: none;">
                        <label for="custom-price" class="form-label"><strong>Enter Price:</strong></label>
                        <input type="number" min="0" step="1" class="form-control" id="custom-price"
                            name="custom_price">
                    </div>

                    <input type="hidden" name="request_id" id="request-id">
                    <input type="hidden" name="service_id" id="service-id">
                    <input type="hidden" name="created_at" id="created-at">
                    <input type="hidden" name="service_name" id="service-name">
                    <input type="hidden" name="price" id="price">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Accept</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>