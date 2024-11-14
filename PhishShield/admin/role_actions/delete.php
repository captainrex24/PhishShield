<?php

include '../../database.php';
include '../../methods/post.php';

header('Content-Type: application/json');

$query = "DELETE FROM roles WHERE id != 1 AND id = :id";
$stmt = $conn->prepare($query);

try {
    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':id', $data['id']);

    // Execute the query
    $stmt->execute();

    $response = [
        'status' => 'success',
        'message' => 'Role deleted successfully!',
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

    $response = [
        'status' => 'error',
        'message' => 'Something went wrong.',
    ];

    http_response_code($error->getCode() ?: 500); // Use the exception code or default to 500
    echo json_encode($response);
}
