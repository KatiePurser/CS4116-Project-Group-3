var serviceRequestModal = document.getElementById('serviceRequestModal')

serviceRequestModal.addEventListener('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    var button = event.relatedTarget;

    // Extract data attributes from the button (message ID and reported user ID)
    var priceFinal = button.getAttribute('data-price-final');
    var serviceId = button.getAttribute('data-service-id');

    var modalPriceFinal = serviceRequestModal.querySelector('#priceFinal');
    var modalServiceId = serviceRequestModal.querySelector('#serviceId');
    
    modalPriceFinal.value = priceFinal;
    modalServiceId.value = serviceId;
    
});