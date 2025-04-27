<!-- Modal for accepting a service request -->
<div class="modal fade" id="acceptRequestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4">

            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="acceptRequestModalLabel">Confirm Accept Request</h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal"></button>
            </div>

            <!-- Form to submit acceptance of a request -->
            <form method="post" action="accept_request.php">
                <div class="modal-body px-5 py-4">

                    <!-- Displaying details -->
                    <p><strong>Request ID:</strong> <span id="request-id-display"></span></p>
                    <p><strong>Service ID:</strong> <span id="service-id-display"></span></p>
                    <p><strong>Created At:</strong> <span id="created-at-display"></span></p>
                    <p><strong>Service Name:</strong> <span id="service-name-display"></span></p>

                    <!-- Displaying price or price range based on service -->
                    <p id="price-display-container"><strong>Price:</strong> <span id="price-display"></span></p>
                    <p id="price-display-range-container"><strong>Price Range:</strong>
                        <span id="price-display-range"></span>
                    </p>

                    <!-- Custom price input field (shown only when needed) -->
                    <div id="price-input-container" class="mt-3" style="display: none;">
                        <label for="custom-price" class="form-label fw-semibold">Enter Price</label>
                        <input type="number" min="100" max="1000" step="1" class="form-control rounded-3 border"
                            id="custom-price" name="custom_price">
                        <!-- Error message for invalid price -->
                        <div id="price-error" class="text-danger mt-1" style="display: none;">
                            Price is not in range!
                        </div>
                    </div>

                    <!-- Hidden fields to pass information to the server -->
                    <input type="hidden" name="request_id" id="request-id">
                    <input type="hidden" name="service_id" id="service-id">
                    <input type="hidden" name="created_at" id="created-at">
                    <input type="hidden" name="service_name" id="service-name">
                    <input type="hidden" name="min_price" id="min-price">
                    <input type="hidden" name="max_price" id="max-price">

                </div>

                <!-- Modal Footer with Accept and Cancel buttons -->
                <div class="modal-footer border-0 px-5 pb-4">
                    <button type="submit" class="submit-btn btn px-4 text-white">Accept</button>
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
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

    .modal-content {
        border-radius: 1rem !important;
    }

    .modal-footer button {
        border-radius: 0.5rem;
    }
</style>