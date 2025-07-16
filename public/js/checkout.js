function showPaymentDetails(select) {
    const selectedOption = select.options[select.selectedIndex];
    const description = selectedOption.getAttribute('data-description');
    const image = selectedOption.getAttribute('data-image');
    
    const detailsContainer = document.getElementById('payment_details');
    const descriptionElement = document.getElementById('payment_description');
    const imageElement = document.getElementById('payment_image');
    
    if (description) {
        descriptionElement.textContent = description;
        detailsContainer.style.display = 'block';
    } else {
        descriptionElement.textContent = '';
    }
    
    if (image) {
        imageElement.src = image;
        imageElement.style.display = 'block';
    } else {
        imageElement.style.display = 'none';
    }
}

$('#btnTambahAlamat').on('click', function () {
    $('#modalPilihAlamat').modal('hide');
    $('#modalPilihAlamat').on('hidden.bs.modal', function () {
      $('#modalTambahAlamat').modal('show');
      $(this).off('hidden.bs.modal');
    });
  });



  


