document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('reviewModal');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const serviceId = button.getAttribute('data-service-id');
        const requestId = button.getAttribute('data-request-id');

        modal.querySelector('#service-id').value = serviceId;
        modal.querySelector('#request-id').value = requestId;
    });
});