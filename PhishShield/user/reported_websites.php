<?php

include '../database.php';
include '../methods/get.php';

header('Content-Type: application/json');

try {
    $query = "SELECT url, allowlist_website_id, blocklist_website_id, created_at FROM reports WHERE allowlist_website_id IS NOT NULL OR blocklist_website_id IS NOT NULL GROUP BY allowlist_website_id, blocklist_website_id ORDER BY created_at DESC;";
    // $query = "SELECT * FROM reports WHERE allowlist_website_id IS NOT NULL OR blocklist_website_id IS NOT NULL ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'status' => 'success',
        'size' => sizeof($result),
        'data' => $result,
    ];

    http_response_code(200);
    echo json_encode($response);
} catch (PDOException $error) {
    $response = [
        'status' => 'error',
        'message' => 'Something went wrong.',
    ];
    http_response_code(500);
    echo json_encode($response);
} catch (Exception $error) {

    if ($error->getCode() == 400) {
        $response = [
            'status' => 'error',
            'message' => [
                'role_name' => json_decode($error->getMessage()),
            ],
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Something went wrong.',
        ];
    }

    http_response_code($error->getCode() ?: 500); // Use the exception code or default to 500
    echo json_encode($response);
}
