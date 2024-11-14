// Get toast element
const toastElement = $('#userToast');
const toast = new bootstrap.Toast(toastElement);

$(document).ready(function () {
    $('[type=password]').val('');
    $('[type=password]').css('color', '');
});