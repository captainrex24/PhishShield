// Add Role
$('#addRoleForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $('#addRoleModal [type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.prop('disabled', true);

    // Get form data
    const data = {
        role_name: $('#role_name').val().trim(),
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

                Object.keys(message).forEach(key => {
                    $(`#${key} + .error-message`).text(message[key]);
                })

            } else {
                toastElement.addClass('bg-danger').removeClass('bg-success');
                toastElement.find('.toast-body').text(xhr.responseJSON.message)
                toast.show()
            }

            submitBtn.prop('disabled', false);
        }
    });
});


// Edit Role
$('.edit-role-btn').on('click', function () {
    const data = $(this).data('role');
    $('#editRoleModal #edit_role_id').val(data.id);
    $('#editRoleModal #edit_role_name').val(data.role_name);

    $.ajax({
        url: $(this).data('url') + `?role_id=${data.id}`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                if (Array.isArray(response.data)) {
                    response.data.forEach(function (permission) {
                        $(`#${permission.module}_${permission.action}`).prop('checked', permission.is_accessible === 1 ? true : false)
                    });
                }
            }
        },
        error: function (xhr, status, error) {
            toastElement.addClass('bg-danger').removeClass('bg-success');
            toastElement.find('.toast-body').text(xhr.responseJSON.message)
            toast.show()
        }
    });
});

$('#editRoleForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $('#editRoleModal [type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.prop('disabled', true);

    let module_actions = [];

    $(this).find('[type="checkbox"]').each(function (index, value) {
        module_actions.push({
            module_action: value.id,
            is_accessible: value.checked,
        });
    });

    // Get form data
    const data = {
        role_id: $('#edit_role_id').val(),
        role_name: $('#edit_role_name').val().trim(),
        module_actions,
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

                Object.keys(message).forEach(key => {
                    $(`#edit_${key} + .error-message`).text(message[key]);
                })

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
$('.delete-role-btn').on('click', function () {
    $('#deleteRoleName').text($(this).data('role-name'))
    $('#delete_role_id').val($(this).data('role-id'))
});

// Delete Role
$('#deleteRoleForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $('#deleteRoleModal [type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.attr('disabled', true);

    // Get form data
    const data = {
        id: $('#delete_role_id').val(),
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


$('#addRoleModal').on('hidden.bs.modal', resetForm)
$('#editRoleModal').on('hidden.bs.modal', resetForm)

function resetForm() {
    $(this).find('form')[0].reset(); // Clear fields and uncheck all checkboxes
    $(this).find('.error-message').text('');
}