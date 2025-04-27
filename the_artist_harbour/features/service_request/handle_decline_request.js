document.addEventListener('DOMContentLoaded', function () {

    // Get the modal by its ID
    const modal = document.getElementById('declineRequestModal');

    // Add an event listener that triggers when the modal is about to be shown
    modal.addEventListener('show.bs.modal', function (event) {

        // Button that triggered the modal
        const button = event.relatedTarget;

        // Retrieve data from the button
        const requestId = button.getAttribute('data-request-id');
        const serviceId = button.getAttribute('data-service-id');
        const createdAt = button.getAttribute('data-created-at');
        const serviceName = button.getAttribute('data-service-name');

        // Populate the hidden input fields inside the modal with the retrieved values
        modal.querySelector('#requestId').value = requestId;
        modal.querySelector('#serviceId').value = serviceId;
        modal.querySelector('#createdAt').value = createdAt;
        modal.querySelector('#serviceName').value = serviceName;
    });
});
