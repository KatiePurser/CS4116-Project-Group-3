document.addEventListener('DOMContentLoaded', function () {

    // Select the modal by its ID
    const modal = document.getElementById('reviewModal');

    // Listen for the event when the modal is about to be shown
    modal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal opening
        const button = event.relatedTarget;

        // Retrieve the service ID and request ID from the button's data attributes
        const serviceId = button.getAttribute('data-service-id');
        const requestId = button.getAttribute('data-request-id');

        // Set the hidden input fields inside the modal form with the retrieved values
        modal.querySelector('#service-id').value = serviceId;
        modal.querySelector('#request-id').value = requestId;
    });
});
