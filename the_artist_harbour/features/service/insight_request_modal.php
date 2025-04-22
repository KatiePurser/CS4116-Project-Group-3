<!-- sender_id, receiver_id, message, pending -->
<div id="insightRequestModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title" id="insightRequestModalLabel">Request Insight</h5>
                <button class="btn-close btn-close-white me-2" data-bs-dismiss="modal" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-5 py-4">
                <form action="submit_insight_request.php" method="post">
                    <input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['user_id'] ?>" >
                    <input type="hidden" name="receiver_id" id="receiverUserId">
                    <input type="hidden" name="service_id" id="serviceId">

                    <div class="mb-4">
                        <label for="message" class="form-label fw-semibold">Message</label>
                        <textarea class="form-control rounded-3 border" id="message" name="message" rows="4"
                            placeholder="Detail your insight request here..." required></textarea>
                    </div>

                    <div class="modal-footer d-flex justify-content-between border-0 px-0">
                        <button type="button" class="btn btn-outline-secondary px-4"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="submit-btn btn px-4">Send Insight Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="insightRequestOutcomeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow-lg rounded-4">

            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title">Insight Request Sent</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center px-4 py-4">
                <div id="actionFeedback" class="alert d-none fw-semibold" role="alert">
                    <!-- Message is dynamically inserted here -->
                </div>

                <button type="button" class="close-btn btn px-4 mt-3 text-white" data-bs-dismiss="modal">Close</button>
            </div>
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

    .modal-header,
    .close-btn {
        background-color: #82689A;
    }

    .close-btn:hover {
        background-color: #5b496d;
    }
</style>