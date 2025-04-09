<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Report Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <form method="post" action="scripts/report_message.php">
                    <input type="hidden" name="message_id" id="reportMessageId">
                    <input type="hidden" name="reported_id" id="reportedId">
                    <input type="hidden" name="reporter_id" value="5"> <!-- NEED TO CHANGE HARD CODED VALUE -->
                    <input type="hidden" name="target_type" value="message">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Reporting</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    #reportModal .modal-content {
        background-color: #82689A;
        color: white;
    }

    #reportModal .btn-primary {
        background-color: #49375a;
        border-color: #49375a;
    }

    #reportModal .btn-primary:hover {
        background-color: rgb(59, 44, 73);
    }

    #reportModal .btn-secondary {
        background-color: #b5a9bf;
        border-color: #b5a9bf;
    }

    #reportModal .btn-secondary:hover {
        background-color: #a395af;
    }
</style>