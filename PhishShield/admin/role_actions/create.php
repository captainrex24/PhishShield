<?php

include '../../database.php';
include '../../methods/post.php';

header('Content-Type: application/json');

try {
    $query = "INSERT INTO roles (role_name) VALUES (:role_name)";
    $stmt = $conn->prepare($query);

    $role_name = $data['role_name'];

    if (empty($role_name)) {
        throw new Exception('', 400);
    }

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':role_name', $role_name);

    // Execute the query
    $stmt->execute();

    $role_id = $conn->lastInsertId();

    foreach ($modules as $module) {
        foreach ($actions as $action) {
            $query = "INSERT INTO permission (role_id, module, action, is_accessible) VALUES (:role_id, :module, :action, 0)";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':role_id', $role_id);
            $stmt->bindParam(':module', $module);
            $stmt->bindParam(':action', $action);
            $stmt->execute();
        }
    }

    $response = [
        'status' => 'success',
        'message' => 'Role created successfully!',
    ];

    http_response_code(201);
    echo json_encode($response);
} catch (PDOException $error) {
    if ($error->getCode() == 23000) {
        $response = [
            'status' => 'error',
            'message' => [
                'role_name' => 'Role name already exists.',
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

    if ($error->getCode() == 400) {
        $response = [
            'status' => 'error',
            'message' => [
                'role_name' => 'Role name is required.',
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
