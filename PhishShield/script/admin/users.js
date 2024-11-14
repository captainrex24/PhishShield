// Add Users
$('#addUserForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $('#addUserModal [type="submit"]');

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
        display_name: $('#display_name').val().trim(),
        role: $('#role').val()?.trim() ?? '',
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
                        window.location.reload();
                    }, 1500);
                })
            }
        },
        error: function (xhr, status, error) {
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


// Edit User
$('.edit-user-btn').on('click', function () {
    const data = $(this).data('user');
    $('#editUserModal #edit_user_id').val(data.user_id);
    $('#editUserModal #edit_first_name').val(data.first_name);
    $('#editUserModal #edit_middle_name').val(data.middle_name);
    $('#editUserModal #edit_last_name').val(data.last_name);
    $('#editUserModal #edit_email').val(data.email);
    $('#editUserModal #edit_username').val(data.username);
    $('#editUserModal #edit_display_name').val(data.display_name);
    $('#editUserModal #edit_role').val(data.role_id);
});

$('#editUserForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $('#editUserModal [type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.prop('disabled', true);

    // Clear error message
    $(this).find('.error-message').text('');

    // Get form data
    const data = {
        user_id: $('#edit_user_id').val().trim(),
        first_name: $('#edit_first_name').val().trim(),
        middle_name: $('#edit_middle_name').val().trim(),
        last_name: $('#edit_last_name').val().trim(),
        email: $('#edit_email').val().trim(),
        username: $('#edit_username').val().trim(),
        password: $('#edit_password').val().trim(),
        display_name: $('#edit_display_name').val().trim(),
        role: $('#edit_role').val()?.trim() ?? '',
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
                        window.location.reload();
                    }, 1500);
                })
            }
        },
        error: function (xhr, status, error) {

            if ([400, 409].includes(xhr.status)) {
                const message = xhr.responseJSON.message;
                
                if (Array.isArray(message)) {
                    console.log(xhr);
                    message.forEach(function (_message) {
                        Object.keys(_message).forEach(key => {
                            console.log(`#edit_${key} + .error-message`);
                            
                            $(`#edit_${key} + .error-message`).text(_message[key]);
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
})


// Delete button
$('.delete-user-btn').on('click', function () {
    $('#deleteUserName').text($(this).data('user-name'))
    $('#delete_user_id').val($(this).data('user-id'))
});

// Delete User
$('#deleteUserForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $('#deleteUserModal [type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.attr('disabled', true);

    // Get form data
    const data = {
        id: $('#delete_user_id').val(),
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
                        window.location.reload();
                    }, 1500);
                })
            }
        },
        error: function (xhr, status, error) {
            toastElement.addClass('bg-danger').removeClass('bg-success');
            toastElement.find('.toast-body').text(xhr.responseJSON.message)
            toast.show()
            submitBtn.attr('disabled', false);
        }
    });
});




$('#addUserModal').on('shown.bs.modal', function () {
    $(this).find('#password').attr('type', 'password')
});

$('#editUserModal').on('shown.bs.modal', function () {
    $(this).find('#edit_password').attr('type', 'password')
});

$('#addUserModal').on('hidden.bs.modal', resetForm)
$('#editUserModal').on('hidden.bs.modal', resetForm)

function resetForm() {
    $(this).find('form')[0].reset(); // Clear fields and uncheck all checkboxes
    $(this).find('.error-message').text('');
}