<div class="modal fade" id="declineRequestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4">

            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="declineRequestModalLabel">Decline Request</h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal"></button>
            </div>

            <form method="post" action="decline_request.php">
                <div class="modal-body px-5 py-4">

                    <p><strong>Request ID:</strong> <span id="decline-request-id-display"></span></p>
                    <p><strong>Service ID:</strong> <span id="decline-service-id-display"></span></p>
                    <p><strong>Created At:</strong> <span id="decline-created-at-display"></span></p>
                    <p><strong>Service Name:</strong> <span id="decline-service-name-display"></span></p>

                    <!-- Hidden fields -->
                    <input type="hidden" name="request_id" id="decline-request-id">
                    <input type="hidden" name="service_id" id="decline-service-id">
                    <input type="hidden" name="created_at" id="decline-created-at">
                    <input type="hidden" name="service_name" id="decline-service-name">

                </div>

                <div class="modal-footer border-0 px-5 pb-4">
                    <button type="submit" class="submit-btn btn px-4 text-white">Decline</button>
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