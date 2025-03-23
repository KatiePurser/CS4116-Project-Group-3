document.addEventListener("DOMContentLoaded", function () {
    // Handle Report Modal Population
    const reportModal = document.getElementById("reportModal");
    if (reportModal) {
        reportModal.addEventListener("show.bs.modal", function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const messageId = button.getAttribute("data-message-id");
            const reportedId = button.getAttribute("data-reported-id");

            // Populate hidden input fields in the modal
            document.getElementById("reportMessageId").value = messageId;
            document.getElementById("reportedId").value = reportedId;
        });
    }
});
