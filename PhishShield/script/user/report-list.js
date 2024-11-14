$('#report_list a').on('click', function (event) {
    event.preventDefault();
    let message = '';
    const isAllowlisted = $(this).data('allowlist')
    const isBlocklisted = $(this).data('blocklist')

    if (isAllowlisted) {
        message = 'SAFE'
        $('#response').attr('class', 'bg-transparent green-alert')
    } else if (isBlocklisted) {
        message = 'MALICIOUS'
        $('#response').attr('class', 'bg-transparent red-alert')
    } else {
        message = 'SUSPICIOUS'
        $('#response').attr('class', 'bg-transparent yellow-alert')
    }
    $('#response').show().html(message)

});