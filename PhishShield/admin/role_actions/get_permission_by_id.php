<?php

include '../../database.php';

$query = "SELECT * FROM permission WHERE role_id = :role_id";
$stmt = $conn->prepare($query);

try {
    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':role_id', $_GET['role_id']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'status' => 'success',
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
}
