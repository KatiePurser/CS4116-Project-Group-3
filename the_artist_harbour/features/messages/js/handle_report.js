var reportModal = document.getElementById('reportModal');
reportModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var messageId = button.getAttribute('data-message-id');
    var reportedId = button.getAttribute('data-reported-id');
    var modalMessageIdInput = reportModal.querySelector('#reportMessageId');
    var modalReportedIdInput = reportModal.querySelector('#reportedId');
    modalMessageIdInput.value = messageId;
    modalReportedIdInput.value = reportedId;
});
