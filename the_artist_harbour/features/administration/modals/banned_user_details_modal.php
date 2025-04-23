<div class="modal fade" id="banned-user-details-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content shadow-lg rounded-4">

            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title fw-bold">Banned User Details</h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 py-3">
                <p><strong>User ID:</strong> <span id="banned-user-modal-user-id"></span></p>
                <p><strong>User Name:</strong> <span id="banned-user-modal-user-name"></span></p>
                <p><strong>Account Type:</strong> <span id="banned-user-modal-user-type"></span></p>
                <p><strong>Ban Reason:</strong> <span id="banned-user-modal-ban-reason"></span></p>
            </div>

            <div class="modal-footer border-0 px-4 pb-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
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