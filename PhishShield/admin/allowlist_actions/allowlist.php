<?php

include '../../database.php';
include '../../methods/post.php';

header('Content-Type: application/json');

try {
    $required_fields = ['url', 'approved_by'];
    $error_messages = [];

    foreach ($required_fields as $required_field) {
        if (empty($data[$required_field])) {
            if (sizeof($error_messages) > 0) {
                throw new Exception('', 400);
            }
        }
    }

    // Begin the transaction
    $conn->beginTransaction();

    // Add website to allowlist
    $query = "INSERT INTO allowlist (url, approved_by) VALUES (:url, :approved_by)";
    $stmt = $conn->prepare($query);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':url', $data['url']);
    $stmt->bindParam(':approved_by', $data['account_id']);

    // Execute the query
    $stmt->execute();

    $allowlist_id = $conn->lastInsertId();

    // All reported websites with the same url will be updated
    $query = "UPDATE reports SET allowlist_website_id = :allowlist_id WHERE url = :url";
    $stmt = $conn->prepare($query);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':url', $data['url']);
    $stmt->bindParam(':allowlist_id', $allowlist_id);

    // Execute the query
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    $response = [
        'status' => 'success',
        'message' => 'Website allowed successfully!',
    ];

    http_response_code(201);
    echo json_encode($response);
} catch (PDOException $error) {
    // Rollback if the transaction is still active
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    $response = [
        'status' => 'error',
        'message' => 'Something went wrong.',
    ];
    http_response_code(500);

    echo json_encode($response);
} catch (Exception $error) {
    // Rollback if the transaction is still active
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    $response = [
        'status' => 'error',
        'message' => 'Something went wrong.',
    ];

    http_response_code($error->getCode() ?: 500); // Use the exception code or default to 500
    echo json_encode($response);
}
