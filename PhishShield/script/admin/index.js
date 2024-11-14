window.addEventListener('load', function () {
    const ctx = $('#reportedWebsitesChart');
    const data = ctx.data('value');
    let labels = [], reportCount = []

    if (Array.isArray(data)) {
        labels = data.map(({ report_month }) => getMonthName(parseInt(report_month.split('-')[1]) - 1));
        reportCount = data.map(({ report_count }) => report_count);
    }

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Reported Websites',
                data: reportCount,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: '#00cadc',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: false,
                    text: 'Reported Websites'
                },
                legend: {
                    display: true // Hides the legend (dataset label) entirely
                }
            },
            scales: {
                x: {
                    display: true,
                },
                y: {
                    display: true,
                    type: 'logarithmic',
                }
            }
        }
    });
});


function getMonthName(index) {
    const months = [
        "January", "February", "March", "April",
        "May", "June", "July", "August",
        "September", "October", "November", "December"
    ];

    return months[index];
}