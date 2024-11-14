<?php

include '../database.php';
include '../methods/get.php';

$query = "SELECT * FROM blacklist";
$stmt = $conn->prepare($query);

try {
    $stmt->execute();
    $reportedUrls = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'status' => 'success',
        'message' => 'Added URL successfully',
        'data' => $reportedUrls,
        'ip_address' => getUserIP(),
    ];

    echo json_encode($response);
} catch (PDOException $error) {
    $response = [
        'status' => 'error',
        'message' => 'Failed to block URL: ' . $error->getMessage(),
    ];

    http_response_code(500);
    echo json_encode($response);
}
