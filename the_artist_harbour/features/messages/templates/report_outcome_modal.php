<div class="modal fade" id="reportOutcomeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow-lg rounded-4">

            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title">Report Submitted</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center px-4 py-4">
                <div id="reportAlert" class="alert d-none fw-semibold" role="alert">
                    <!-- Message is dynamically inserted here -->
                </div>

                <button type="button" class="close-btn btn px-4 mt-3 text-white" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-header,
    .close-btn {
        background-color: #82689A;
    }

    .close-btn:hover {
        background-color: #5b496d;
    }
</style>