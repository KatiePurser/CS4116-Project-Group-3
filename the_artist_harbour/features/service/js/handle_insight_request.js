var insightRequestModal = document.getElementById('insightRequestModal')

insightRequestModal.addEventListener('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    var button = event.relatedTarget;

    // Extract data attributes from the button (message ID and reported user ID)
    var receiverUserId = button.getAttribute('data-receiver-id');
    var serviceId = button.getAttribute('data-service-id');

    // Find the hidden input fields inside the modal
    var modalReceiverUserIdInput = insightRequestModal.querySelector('#receiverUserId');
    var modalServiceId = insightRequestModal.querySelector('#serviceId');
    
    // Set the values of the hidden inputs so they can be submitted with the form
    modalReceiverUserIdInput.value = receiverUserId;
    modalServiceId.value = serviceId;
});