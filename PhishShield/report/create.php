<?php

include '../database.php';
include '../methods/post.php';

header('Content-Type: application/json');

$query = "INSERT INTO blacklist (url) VALUES (:url)";
$stmt = $conn->prepare($query);

try {
    $stmt->execute([
        'url' => $data['url'],
    ]);

    $response = [
        'status' => 'success',
        'message' => 'Added URL successfully',
        'data' => $data
    ];

    http_response_code(201);
    echo json_encode($response);
} catch (PDOException $error) {
    $response = [
        'status' => 'error',
        'message' => 'Failed to block URL: ' . $error->getMessage(),
    ];

    http_response_code(500);
    echo json_encode($response);
}
