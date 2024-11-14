$(document).ready(function () {
    dataTableInit('allowlist_actions/get.php', [
        { data: "url" },
        { data: "created_at" },
        { data: "actions", orderable: false, searchable: false }
    ])
});

// Add Website
$('#addWebsiteForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $('#addWebsiteModal [type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.prop('disabled', true);

    // Clear error message
    $(this).find('.error-message').text('');

    // Get form data
    const data = {
        website_url: $('#website_url').val().trim(),
        account_id: $('#account_id').val().trim(),
        username: $('#username').val().trim(),
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
                            if (key === 'website_url') {
                                _message[key] = _message[key].replace('url', 'URL');
                            }

                            $(`#${key} + .error-message`).text(_message[key]);
                        });
                    });
                } else {
                    toastElement.addClass('bg-danger').removeClass('bg-success');
                    toastElement.find('.toast-body').text(message)
                    toast.show()
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


// Edit Website
function editWebsiteHandler(target) {
    const data = $(target).data('website');
    $('#editWebsiteModal #edit_website_id').val(data.id);
    $('#editWebsiteModal #edit_website_url').val(data.url);
    $('#editWebsiteModal #edit_website_status').val('allowlist');
}

$('#editWebsiteForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $('#editWebsiteModal [type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.prop('disabled', true);

    // Clear error message
    $(this).find('.error-message').text('');

    // Get form data
    const data = {
        website_id: $('#edit_website_id').val().trim(),
        url: $('#edit_website_url').val().trim(),
        account_id: $('#edit_account_id').val().trim(),
        status: $('#edit_website_status').val().trim(),
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
                console.log(xhr);
                const message = xhr.responseJSON.message;

                if (Array.isArray(message)) {
                    message.forEach(function (_message) {
                        Object.keys(_message).forEach(key => {
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
function deleteWebsiteHandler(target) {
    $('#delete_website_id').val($(target).data('website-id'))
}

// Delete Website
$('#deleteWebsiteForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $('#deleteModal [type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.attr('disabled', true);

    // Get form data
    const data = {
        id: $('#delete_website_id').val(),
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




$('#addWebsiteModal').on('shown.bs.modal', function () {
    $(this).find('#password').attr('type', 'password')
});

$('#editWebsiteModal').on('shown.bs.modal', function () {
    $(this).find('#edit_password').attr('type', 'password')
});

$('#addWebsiteModal').on('hidden.bs.modal', resetForm)
$('#editWebsiteModal').on('hidden.bs.modal', resetForm)

function resetForm() {
    $(this).find('form')[0].reset(); // Clear fields and uncheck all checkboxes
    $(this).find('.error-message').text('');
}