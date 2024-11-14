document.addEventListener('DOMContentLoaded', async function () {
    let activeTab = await getCurrentTab();
    let isSafe = true, isSuspicious = false;

    document.getElementById('report_site').addEventListener('click', reportEventHandler);

    if (isUrlRestricted(activeTab.url)) {
        isSafe = true
        isSuspicious = false
    } else {
        let scanResult = await virusTotalScanner(activeTab.url); // Scan from Virus Total
        let predictionResult = await predictUrl(activeTab.url); // Prediction from Machine Learning

        console.log('[Virus Total]:', scanResult);
        console.log('[Machine Learning]:', predictionResult);

        // if(scanResult.data.malicious !== 0 && predictionResult.status !== 'Safe')

        if (predictionResult.status === 'Reported') {
            isSafe = false
            isSuspicious = true
        } else if ((scanResult.data.malicious !== 0 && predictionResult.status === 'Safe') || (scanResult.data.malicious === 0 && predictionResult.status !== 'Safe')) {
            isSafe = false
            isSuspicious = false
        } else {
            isSafe = true
            isSuspicious = false
        }
    }

    document.body.classList.toggle('safe-website', isSafe)
    document.body.classList.toggle('suspicious-website', isSuspicious)

    document.getElementById('loader').remove();
    document.body.classList.remove('loading');
});


async function reportEventHandler() {
    let activeTab = await getCurrentTab();
    if (isUrlRestricted(activeTab.url)) return;
    chrome.tabs.create({ url: 'http://localhost/phishshield/report-website.php?report_url=' + activeTab.url });
}


async function getCurrentTab() {
    let tab = await chrome.tabs.query({ active: true, currentWindow: true });
    return tab[0];
}

// Check if the URL is restricted (chrome://, about://, etc.)
function isUrlRestricted(currentTabUrl = '') {
    return ['chrome://', 'edge://', 'about://', 'file://'].some(function (restrictedURL) {
        return currentTabUrl.startsWith(restrictedURL)
    });
}

// Scan By Virus Total
async function virusTotalScanner(url) {
    const response = await fetch('http://localhost/phishshield/user/virus-total-api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ url })
    })

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    return await response.json();
}

// Machine Learning
async function predictUrl(url) {
    const response = await fetch('http://localhost:5000/predict', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ url })
    })

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    return await response.json();
}