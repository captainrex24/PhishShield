<?php

include '../../database.php';
include '../../methods/post.php';

header('Content-Type: application/json');

try {
    $role_id = $data['role_id'];
    $role_name = $data['role_name'];
    $module_actions = $data['module_actions'];

    if (empty($role_name)) {
        throw new Exception('', 400);
    }

    $query = "UPDATE roles SET role_name = :role_name WHERE id = :id";
    $stmt = $conn->prepare($query);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':id', $role_id);
    $stmt->bindParam(':role_name', $role_name);

    // Execute the query
    $stmt->execute();

    foreach ($module_actions as $module_action) {
        $is_accessible = $module_action['is_accessible']; // True or False
        $module_action = explode('_', $module_action['module_action']);
        $module = $module_action[0]; // Example: reports
        $action = $module_action[1]; // Example: create

        if (in_array($module, $modules) && in_array($action, $actions)) {
            $query = "UPDATE permission SET is_accessible = :is_accessible WHERE role_id = :role_id AND module = :module AND action = :action";
            $stmt = $conn->prepare($query);

            // Bind parameters to prevent SQL injection
            $stmt->bindParam(':is_accessible', $is_accessible);
            $stmt->bindParam(':role_id', $role_id);
            $stmt->bindParam(':module', $module);
            $stmt->bindParam(':action', $action);

            // Execute the query
            $stmt->execute();
        }
    }

    $response = [
        'status' => 'success',
        'message' => 'Role updated successfully!',
    ];

    http_response_code(200);
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
