$('#registerForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $(this).find('[type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.prop('disabled', true);

    // Clear error message
    $(this).find('.error-message').text('');

    // Get form data
    const data = {
        first_name: $('#first_name').val().trim(),
        middle_name: $('#middle_name').val().trim(),
        last_name: $('#last_name').val().trim(),
        email: $('#email').val().trim(),
        username: $('#username').val().trim(),
        password: $('#password').val().trim(),
        confirm_password: $('#confirm_password').val().trim(),
    };

    $.ajax({
        url: event.target.action,
        type: 'POST',
        data: JSON.stringify(data), // Send data as JSON
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                toastElement.addClass('bg-success').removeClass('bg-danger');
                toastElement.find('.toast-body').text(response.message)
                toast.show()

                toastElement.on('shown.bs.toast', function () {
                    setTimeout(() => {
                        window.location.href = "http://localhost/phishshield/login.php"
                    }, 1500);
                })
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);

            if ([400, 409].includes(xhr.status)) {
                const message = xhr.responseJSON.message;

                if (Array.isArray(message)) {
                    message.forEach(function (_message) {
                        Object.keys(_message).forEach(key => {
                            $(`#${key} + .error-message`).text(_message[key]);
                        });
                    });
                }
            } else {
                toastElement.addClass('bg-danger').removeClass('bg-success');
                toastElement.find('.toast-body').text(xhr.responseJSON.message)
                toast.show()
            }

            submitBtn.prop('disabled', false);
        }
    });
});


const passwordEyeBtn = $('.password-container .password-eye')
const passwordEyeOffBtn = $('.password-container .password-eye-off')
const password = $('.password-container #password')

passwordEyeBtn.on('click', function () {
    $(this).hide();
    passwordEyeOffBtn.show();
    password.attr('type', 'text');
})

passwordEyeOffBtn.on('click', function () {
    $(this).hide();
    passwordEyeBtn.show();
    password.attr('type', 'password');
})

const confirmPasswordEyeBtn = $('.confirm-password-container .password-eye')
const confirmPasswordEyeOffBtn = $('.confirm-password-container .password-eye-off')
const confirmPassword = $('.confirm-password-container #confirm_password')

confirmPasswordEyeBtn.on('click', function () {
    $(this).hide();
    confirmPasswordEyeOffBtn.show();
    confirmPassword.attr('type', 'text');
})

confirmPasswordEyeOffBtn.on('click', function () {
    $(this).hide();
    confirmPasswordEyeBtn.show();
    confirmPassword.attr('type', 'password');
})
