<div class="modal fade" id="reportOutcomeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Report Submitted</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                <div id="reportAlert" class="alert d-none" role="alert">
                    <!-- Message is being set dynamically in report_outcome.js -->
                </div>

                <button type="button" class="btn btn-primary mt-3" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<style>
    #reportOutcomeModal .modal-content {
        background-color: #82689A;
        color: white;
    }

    #reportAlert.alert-success {
        background-color: rgb(68, 192, 114);
        color: white;
    }

    #reportOutcomeModal .btn-primary {
        background-color: #49375a;
        border-color: #49375a;
    }

    #reportOutcomeModal .btn-primary:hover {
        background-color: rgb(59, 44, 73);
    }
</style>