<?php

include '../../database.php';
include '../../methods/post.php';

header('Content-Type: application/json');

try {
    $required_fields = ['website_id', 'url', 'account_id', 'status'];
    $error_messages = [];

    foreach ($required_fields as $required_field) {
        if (empty($data[$required_field])) {
            array_push($error_messages, [
                $required_field => ucfirst(str_replace('_', ' ', $required_field)) . ' is required.',
            ]);
        }
    }

    if (sizeof($error_messages) > 0) {
        throw new Exception(json_encode($error_messages), 400);
    }

    // Begin the transaction
    $conn->beginTransaction();

    // Transfer to allowlist table
    if ($data['status'] == 'allowlist') {
        $query = "SELECT COUNT(*) FROM allowlist WHERE url = :url";
        $stmt = $conn->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':url', $data['url']);

        // Execute the query
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            throw new Exception('The website is already in the allowlist.', 409);
        }


        // Add website to allowlist
        $query = "INSERT INTO allowlist (url, approved_by) VALUES (:url, :approved_by)";
        $stmt = $conn->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':url', $data['url']);
        $stmt->bindParam(':approved_by', $data['account_id']);

        // Execute the query
        $stmt->execute();

        $allowlist_id = $conn->lastInsertId();


        // Update report
        $query = "UPDATE reports SET url = :url, allowlist_website_id = :allowlist_website_id, blocklist_website_id = NULL  WHERE blocklist_website_id = :website_id";
        $stmt = $conn->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':website_id', $data['website_id']);
        $stmt->bindParam(':url', $data['url']);
        $stmt->bindParam(':allowlist_website_id', $allowlist_id);

        // Execute the query
        $stmt->execute();


        // Delete website from blocklist
        $query = "DELETE FROM blocklist WHERE id = :website_id";
        $stmt = $conn->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':website_id', $data['website_id']);

        // Execute the query
        $stmt->execute();
    } else {
        // Update website
        $query = "UPDATE blocklist SET url = :url WHERE id = :website_id";
        $stmt = $conn->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':website_id', $data['website_id']);
        $stmt->bindParam(':url', $data['url']);

        // Execute the query
        $stmt->execute();


        // Update report
        $query = "UPDATE reports SET url = :url  WHERE blocklist_website_id = :website_id";
        $stmt = $conn->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':website_id', $data['website_id']);
        $stmt->bindParam(':url', $data['url']);

        // Execute the query
        $stmt->execute();
    }

    // Commit the transaction
    $conn->commit();

    $response = [
        'status' => 'success',
        'message' => 'Website updated successfully!',
    ];

    http_response_code(200);
    echo json_encode($response);
} catch (PDOException $error) {
    // Rollback if the transaction is still active
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    if ($error->getCode() == 23000) {
        $response = [
            'status' => 'error',
            'message' => [
                [
                    'website_url' => 'Website URL already exists.',
                ]
            ],
        ];
        http_response_code(409);
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Something went wrong.',
        ];
        http_response_code(500);
    }

    echo json_encode($response);
} catch (Exception $error) {
    // Rollback if the transaction is still active
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    if ($error->getCode() == 400) {
        $response = [
            'status' => 'error',
            'message' => json_decode($error->getMessage()),
        ];
    } else if ($error->getCode() == 409) {
        $response = [
            'status' => 'error',
            'message' => $error->getMessage(),
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
