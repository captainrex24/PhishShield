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