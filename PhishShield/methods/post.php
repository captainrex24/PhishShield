<?php

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // 405 Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Only POST method is allowed']);
    exit;
}

// Capture POST data
// If data is sent as JSON, use php://input to read the raw POST body
$postData = file_get_contents('php://input');
$data = json_decode($postData, true); // Decode JSON data into an associative array

// Check if the data is received correctly
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // 400 Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
    exit;
}
