$(document).ready(function () {
    dataTableInit('report_actions/get.php', [
        { data: "url" },
        { data: "username" },
        { data: "created_at" },
        { data: "actions", orderable: false, searchable: false }
    ])
});

function allowlistHandler(target) {
    // Disable submit button to avoid multiple submit
    const btn = $(target)
    btn.prop('disabled', true);

    // Get form data
    const data = {
        url: btn.data('reported-url'),
        account_id: btn.data('admin-id'),
    };

    $.ajax({
        url: btn.data('url'),
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

            btn.prop('disabled', false);
        }
    });

}


function blocklistHandler(target) {
    // Disable submit button to avoid multiple submit
    const btn = $(target)
    btn.prop('disabled', true);

    // Get form data
    const data = {
        url: btn.data('reported-url'),
        account_id: btn.data('admin-id'),
    };

    $.ajax({
        url: btn.data('url'),
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

            btn.prop('disabled', false);
        }
    });

}