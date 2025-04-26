document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const actionStatus = urlParams.get('outcome');
    const action = urlParams.get('action')
    
    if(action == '0'){
        const reviewReportOutcomeModal = new bootstrap.Modal(document.getElementById('reviewReportOutcomeModal'));
        if (actionStatus) {
            const actionAlert = document.getElementById('actionFeedbackReview');
            actionAlert.classList.remove('d-none');
            actionAlert.classList.add(actionStatus === 'success' ? 'alert-success' : 'alert-danger');
            actionAlert.textContent = actionStatus === 'success'
                ? 'Report submitted successfully!'
                : 'Failed to submit report. Please try again.';
            reviewReportOutcomeModal.show();
        }
    }else if(action == '1'){
        const insightRequestOutcomeModal = new bootstrap.Modal(document.getElementById('insightRequestOutcomeModal'));
        if (actionStatus) {
            const actionAlert = document.getElementById('actionFeedbackInsight');
            actionAlert.classList.remove('d-none');
            actionAlert.classList.add(actionStatus === 'success' ? 'alert-success' : 'alert-danger');
            actionAlert.textContent = actionStatus === 'success'
                ? 'Insight request sent successfully!'
                : 'Failed to send insight request. Please try again.';
            insightRequestOutcomeModal.show();
        }
    }else if(action == '2'){
        const serviceRequestOutcomeModal = new bootstrap.Modal(document.getElementById('serviceRequestOutcomeModal'));
        if(actionStatus) {
            const actionAlert = document.getElementById('actionFeedbackService');
            actionAlert.classList.remove('d-none');
            actionAlert.classList.add(actionStatus === 'success' ? 'alert-success' : 'alert-danger');
            actionAlert.textContent = actionStatus === 'success'
                ? 'Service request sent successfully!'
                : 'Failed to send service request. Please try again.';
            serviceRequestOutcomeModal.show();
        }
    }
});