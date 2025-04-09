<div class="modal fade" id="acceptRequestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acceptRequestModalLabel">Accept Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <form method="post" action="accept_request.php">
                    <input type="hidden" name="request_id" id="requestId">
                    <input type="hidden" name="service_id" id="serviceId">
                    <input type="hidden" name="created_at" id="createdAt">
                    <input type="hidden" name="service_name" id="serviceName">
                    <input type="hidden" name="price" id="price">

                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Service Name:</label>
                        <p id="serviceNameDisplay" class="form-control-plaintext"></p>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <p id="priceDisplay" class="form-control-plaintext"></p>
                    </div>

                    <div class="mb-3">
                        <label for="time" class="form-label">Time:</label>
                        <p id="timeDisplay" class="form-control-plaintext"></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>