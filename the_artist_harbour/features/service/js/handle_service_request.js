var serviceRequestModal = document.getElementById('serviceRequestModal')

serviceRequestModal.addEventListener('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    var button = event.relatedTarget;

    // Extract data attributes from the button (message ID and reported user ID)
    var priceMin = button.getAttribute('data-price-min');
    var priceMax = button.getAttribute('data-price-max');
    var serviceId = button.getAttribute('data-service-id');

    var modalPriceMin = serviceRequestModal.querySelector('#priceMin');
    var modalPriceMax = serviceRequestModal.querySelector('#priceMax');
    var modalServiceId = serviceRequestModal.querySelector('#serviceId');
    
    modalPriceMin.value = priceMin;
    modalPriceMax.value = priceMax;
    modalServiceId.value = serviceId;
    
});