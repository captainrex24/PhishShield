<?php

include '../methods/post.php';

// Your Google API key
$apiKey = "AIzaSyA5a99OxWNL8tBp6fkF5azkqBWjW-pAKxI";

// Safe Browsing API endpoint
$url = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=$apiKey";

// Payload with the URL you want to check
$data = [
    "client" => [
        "clientId" => "yourcompanyname",
        "clientVersion" => "1.0"
    ],
    "threatInfo" => [
        "threatTypes" => ["THREAT_TYPE_UNSPECIFIED", "MALWARE", "SOCIAL_ENGINEERING", "UNWANTED_SOFTWARE", "POTENTIALLY_HARMFUL_APPLICATION"],
        "platformTypes" => ["ANY_PLATFORM"],
        "threatEntryTypes" => ["URL"],
        "threatEntries" => [
            ["url" => $data['url']]
        ]
    ]
];

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute the API request
$response = curl_exec($ch);
curl_close($ch);

// Parse the response
$result = json_decode($response, true);

// Check if any threat matches were found
if (!empty($result['matches'])) {
    echo "URL is unsafe:\n";
    print_r($result['matches']);
} else {
    echo "URL is safe.\n";
}




// // Your API Key from ipqualityscore.com
// $key = 'WNXblbA5GDM39tmtzTJwUEG2qwioSmAW';

// // Type of API request (scan or lookup)
// $type = 'scan';

// // Create API URL
// $url = sprintf(
//     'https://www.ipqualityscore.com/api/json/malware/%s/%s',
//     $type,
//     $key
// );

// // The file you want to scan
// $file_to_scan = $data['url'];

// // Fetch The Result
// $timeout = 5;

// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
// curl_setopt($curl, CURLOPT_POST, 1);
// curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
// curl_setopt($curl, CURLOPT_POSTFIELDS, [
//     'file' => new CURLFile($file_to_scan),
// ]);
// $json = curl_exec($curl);
// curl_close($curl);

// // Decode the result into an array.
// $result = json_decode($json, true);

// var_dump($result);

// // Check to see if our query was successful.
// if (isset($result['success']) && $result['success'] === true) {
//     return $result;
//     var_dump($result);
// }
