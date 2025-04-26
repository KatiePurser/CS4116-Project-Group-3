<div class="modal fade" id="reportDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4">

            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title fw-bold">Report Details</h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 py-3">
                <p class="text-danger" id="report-details-modal-user-is-already-banned-warning"><strong>This user is currently banned!</strong></p>
                <p><strong>Report ID:</strong> <span id="report-details-modal-report-id"></span></p>
                <p><strong>Reported User ID:</strong> <span id="report-details-modal-reported-user-id"></span></p>
                <p><strong>Type:</strong> <span id="report-details-modal-report-type"></span></p>
                <p><strong>Content:</strong> <span id="report-details-modal-report-content"</p>
                <p><strong>Reason:</strong> <span id="report-details-modal-report-reason"></span></p>
            </div>

            <div class="modal-footer border-0 px-4 pb-3 justify-content-between" id="modal-footer-actions">
            </div>
        </div>
    </div>
</div>

<style>
    .modal-header {
        background-color: #82689A;
    }

    .modal-title {
        padding: 10px;
    }
</style>
