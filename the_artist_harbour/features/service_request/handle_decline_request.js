document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('declineRequestModal');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const requestId = button.getAttribute('data-request-id');
        const serviceId = button.getAttribute('data-service-id');
        const createdAt = button.getAttribute('data-created-at');
        const serviceName = button.getAttribute('data-service-name');

        modal.querySelector('#requestId').value = requestId;
        modal.querySelector('#serviceId').value = serviceId;
        modal.querySelector('#createdAt').value = createdAt;
        modal.querySelector('#serviceName').value = serviceName;
    });
});