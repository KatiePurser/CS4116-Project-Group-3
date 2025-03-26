document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const reportStatus = urlParams.get('report');
    const reportAlert = document.getElementById('reportAlert');
    const reportOutcomeModal = new bootstrap.Modal(document.getElementById('reportOutcomeModal'));

    if (reportStatus) {
        reportAlert.classList.remove('d-none');
        reportAlert.classList.add(reportStatus === 'success' ? 'alert-success' : 'alert-danger');
        reportAlert.textContent = reportStatus === 'success'
            ? 'Report submitted successfully!'
            : 'Failed to submit report. Please try again.';
        reportOutcomeModal.show();
    }
});