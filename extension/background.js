chrome.tabs.onUpdated.addListener(onUpdatedHandler);

async function onUpdatedHandler(tabId, changeInfo, tab) {
    if (changeInfo.status === 'complete' && tab.active) {
        const currentTabUrl = tab.url;
        let isSafe = true;
        let isMalicious = false;


        // Algorithm
        // Check the URL using malicious website API
        // Check URL using Machine Learning

        if (isUrlRestricted(currentTabUrl)) return;

        try {
            let scanResult = await virusTotalScanner(tab.url); // Scan from Virus Total
            let predictionResult = await predictUrl(currentTabUrl); // Prediction from Machine Learning
            let popup = 'popup.html'

            if (scanResult.data.malicious !== 0 && predictionResult.status !== 'Safe') {
                isSafe = false
                isMalicious = true
                popup = ''

                chrome.tabs.sendMessage(tabId, { channel: "reported" });
            } else if ((scanResult.data.malicious !== 0 && predictionResult.status === 'Safe') || (scanResult.data.malicious === 0 && predictionResult.status !== 'Safe')) {
                isSafe = false
                isMalicious = false
            } else {
                isSafe = true
                isMalicious = false
            }

            chrome.action.setPopup({ tabId: tabId, popup });
        } catch (error) {
            console.log('Error:', error);
        }

        return true;
    }
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