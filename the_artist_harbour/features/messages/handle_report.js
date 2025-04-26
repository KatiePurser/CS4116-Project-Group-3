var reportModal = document.getElementById('reportModal');

// Add an event listener to the modal 
reportModal.addEventListener('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    var button = event.relatedTarget;

    // Extract data attributes from the button (message ID and reported user ID)
    var messageId = button.getAttribute('data-message-id');
    var reportedUserId = button.getAttribute('data-reported-user-id');
    var reporterUserId = button.getAttribute('data-reporter-user-id');
    var messageContent = button.getAttribute('data-message-content');
    var conversationId = button.getAttribute('data-conversation-id');


    // Find the hidden input fields inside the modal
    var modalMessageIdInput = reportModal.querySelector('#reportMessageId');
    var modalReportedUserIdInput = reportModal.querySelector('#reportedUserId');
    var modalReporterUserIdInput = reportModal.querySelector('#reporterUserId');
    var modalMessageContentInput = reportModal.querySelector('#messageContent');
    var modalConversationIdInput = reportModal.querySelector('#conversationId');
    
    // Set the values of the hidden inputs so they can be submitted with the form
    modalMessageIdInput.value = messageId;
    modalReportedUserIdInput.value = reportedUserId;
    modalReporterUserIdInput.value = reporterUserId;
    modalMessageContentInput.value = messageContent;
    modalConversationIdInput.value = conversationId;
});
