<?php

include '../../database.php';
include '../../methods/post.php';

header('Content-Type: application/json');

try {
    $required_fields = ['user_id', 'first_name', 'last_name', 'email', 'username', 'role'];
    $error_messages = [];

    foreach ($required_fields as $required_field) {
        if (empty($data[$required_field])) {
            array_push($error_messages, [
                $required_field => ucfirst(str_replace('_', ' ', $required_field)) . ' is required.',
            ]);
        }
    }

    if (!empty($data['password'])) {
        if (strlen($data['password']) < 8) {
            array_push($error_messages, [
                'password' => 'Your password must contain a minimum of 8 characters.',
            ]);
        }
    }

    if (sizeof($error_messages) > 0) {
        throw new Exception(json_encode($error_messages), 400);
    }


    // Begin the transaction
    $conn->beginTransaction();

    // Update user
    $query = "UPDATE users SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, email = :email WHERE id = :user_id";
    $stmt = $conn->prepare($query);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':user_id', $data['user_id']);
    $stmt->bindParam(':first_name', $data['first_name']);
    $stmt->bindParam(':middle_name', $data['middle_name']);
    $stmt->bindParam(':last_name', $data['last_name']);
    $stmt->bindParam(':email', $data['email']);

    // Execute the query
    $stmt->execute();


    // Update user account
    if (!empty($data['password'])) {
        $query = "UPDATE accounts SET role_id = :role_id, username = :username, password = :password, display_name = :display_name WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);
    } else {
        $query = "UPDATE accounts SET role_id = :role_id, username = :username, display_name = :display_name WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
    }

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':user_id', $data['user_id']);
    $stmt->bindParam(':role_id', $data['role']);
    $stmt->bindParam(':username', $data['username']);
    $stmt->bindParam(':display_name', $data['display_name']);

    // Execute the query
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    $response = [
        'status' => 'success',
        'message' => 'User updated successfully!',
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
                    'username' => 'Username already exists.',
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
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Something went wrong.',
        ];
    }

    http_response_code($error->getCode() ?: 500); // Use the exception code or default to 500
    echo json_encode($response);
}
