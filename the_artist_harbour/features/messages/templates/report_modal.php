<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title" id="reportModalLabel">Report Message</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-5 py-4">
                <form method="post" action="scripts/report_message.php">
                    <input type="hidden" name="message_id" id="reportMessageId">
                    <input type="hidden" name="reported_user_id" id="reportedUserId">
                    <input type="hidden" name="reporter_user_id" id="reporterUserId">
                    <input type="hidden" name="target_type" value="message">
                    <input type="hidden" name="message_content" id="messageContent">
                    <input type="hidden" name="conversation_id" id="conversationId">

                    <div class="mb-4">
                        <label for="reason" class="form-label fw-semibold">Reason for Reporting</label>
                        <textarea class="form-control rounded-3 border" id="reason" name="reason" rows="4"
                            placeholder="Describe the issue clearly..." required></textarea>
                    </div>

                    <div class="modal-footer d-flex justify-content-between border-0 px-0">
                        <button type="button" class="btn btn-outline-secondary px-4"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="submit-btn btn text-white px-4">Submit Report</button>
                    </div>
                </form>
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
</style>