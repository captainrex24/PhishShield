<?php

function getUrlReport($url)
{
    $apiKey = '9b1159b70a5fd7a60fe0520dccacdec784832567e135ccebb7665de6badaf3cc';

    // Encode URL and create endpoint
    $urlId = rtrim(base64_encode($url), '=');
    $endpoint = "https://www.virustotal.com/api/v3/urls/$urlId";

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "x-apikey: $apiKey",
        "Content-Type: application/json"
    ]);

    // Execute the request
    $result = curl_exec($ch);

    // Default data if request fails
    $defaultData = [
        'data' => [
            'malicious' => 0,
            'suspicious' => 0,
            'undetected' => 0,
            'harmless' => 0,
            'timeout' => 0
        ]
    ];

    // Check for errors
    if (curl_errno($ch)) {
        curl_close($ch);
        return json_encode($defaultData);
    }

    // Close cURL session
    curl_close($ch);

    // Decode and parse the result
    $response = json_decode($result, true);

    // Check if the necessary data exists in the response
    if (isset($response['data']['attributes']['last_analysis_stats'])) {
        return json_encode([
            'data' => $response['data']['attributes']['last_analysis_stats']
        ]);
    } else {
        return json_encode($defaultData);
    }
}