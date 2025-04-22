var reviewReportModal = document.getElementById('reviewReportModal')

reviewReportModal.addEventListener('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    var button = event.relatedTarget;

    // Extract data attributes from the button (message ID and reported user ID)
    var reviewId = button.getAttribute('data-review-id');
    var serviceId = button.getAttribute('data-service-id');
    var reportedUserId = button.getAttribute('data-reported-id');
    var reviewContent = button.getAttribute('data-review-content');

    var modalReviewId = reviewReportModal.querySelector('#reviewId');
    var modalServiceId = reviewReportModal.querySelector('#serviceId');
    var modalReportedUserId = reviewReportModal.querySelector('#reportedUserId');
    var modalReviewContent = reviewReportModal.querySelector('#reviewContent');
    
    modalReviewId.value = reviewId;
    modalServiceId.value = serviceId;
    modalReportedUserId.value = reportedUserId;
    modalReviewContent.value = reviewContent;
    
});