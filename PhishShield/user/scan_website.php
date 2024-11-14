<?php

include '../database.php';
include '../methods/post.php';

header('Content-Type: application/json');

$data = json_encode(['url' => $data['search']]);

function checkURL($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        $result = false;
    }

    curl_close($ch);
    return json_decode($result);
}

echo json_encode([
    'prediction_result' => checkURL("http://localhost:5000/predict", $data),
    'virus_total_scan_result' => checkURL("http://localhost/phishshield/user/virus-total-api.php", $data)
]);

// try {
//     // Prepare the query without the wildcards in the SQL
//     $query = "SELECT COUNT(*) FROM blocklist WHERE url LIKE :search";

//     $stmt = $conn->prepare($query);

//     // Bind the parameter with wildcards
//     $searchParam = '%' . $data['search'] . '%';
//     $stmt->bindParam(':search', $searchParam);

//     $stmt->execute();

//     // Fetch the result
//     $count = $stmt->fetchColumn();

//     if ($count > 0) {
//         $response = [
//             'status' => 'success',
//             'message' => '<small class="error-message text-danger d-block w-100"><strong>Warning</strong>: Phishing Site Detected</small>',
//         ];
//     } else {
//         $response = [
//             'status' => 'success',
//             'message' => '<small class="success-message text-success d-block w-100">No Phishing Threat Detected</small>',
//         ];
//     }
//     http_response_code(200);
//     echo json_encode($response);
// } catch (PDOException $error) {
//     $response = [
//         'status' => 'error',
//         'message' => '<small class="error-message text-danger d-block w-100">Something went wrong.</small>',
//     ];
//     http_response_code(500);
//     echo json_encode($response);
// }
