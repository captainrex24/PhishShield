$('#search').on('input', function (event) {
    $('#scannerForm [type="submit"]').prop('disabled', event.target.value.length === 0)
});

$('#scannerForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $(this).find('[type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.prop('disabled', true);

    // Get form data
    const data = {
        search: $('#search').val().trim(),
    };

    $.ajax({
        url: event.target.action,
        type: 'POST',
        data: JSON.stringify(data), // Send data as JSON
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function (response) {
            let predictionResult = response.prediction_result;
            let scanResult = response.virus_total_scan_result;


            if (scanResult.data.malicious !== 0 && predictionResult.status !== 'Safe') {
                $('#response').show().html('This link is Phishing!').attr('class', 'red-alert')
            } else if ((scanResult.data.malicious !== 0 && predictionResult.status === 'Safe') || (scanResult.data.malicious === 0 && predictionResult.status !== 'Safe')) {
                $('#response').show().html('This link is Suspicious').attr('class', 'yellow-alert')
            } else {
                $('#response').show().html('The Link is Safe!').attr('class', 'green-alert')
            }
        },
        error: function (xhr, status, error) {
            // console.log(xhr.respons);


            submitBtn.prop('disabled', false);
        }
    });
});


$('.write-review-btn').on('click', function () {
    $("#write_review_form_container")[0].scrollIntoView();
});

$('#reviewForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $(this).find('[type="submit"]');

    // Disable submit button to avoid multiple submit
    submitBtn.prop('disabled', true);

    // Get form data
    const data = {
        user_id: $('#user_id').val(),
        rating: $('[name="rating"]:checked').val() ?? '',
        review: $('#review').val().trim(),
    };

    console.log(data);

    $(`.error-message`).html('');


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
            console.log(xhr);

            if ([400].includes(xhr.status)) {
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


var swiper = new Swiper(".swiper", {
    autoHeight: true, //enable auto height
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
    },
});