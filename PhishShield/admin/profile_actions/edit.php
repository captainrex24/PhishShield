<?php

include '../../database.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        throw new Exception('Invalid request method.', 405);
    }

    $required_fields = ['user_id', 'first_name', 'last_name', 'email', 'username', 'display_name'];
    $error_messages = [];

    foreach ($required_fields as $required_field) {
        if (empty($_POST[$required_field])) {
            array_push($error_messages, [
                $required_field => ucfirst(str_replace('_', ' ', $required_field)) . ' is required.',
            ]);
        }
    }
    if (!empty($_POST['password'])) {
        if (strlen($_POST['password']) < 8) {
            array_push($error_messages, [
                'password' => 'Your password must contain a minimum of 8 characters.',
            ]);
        }

        if ($_POST['password'] != $_POST['confirm_password']) {
            array_push($error_messages, [
                'password' => 'Password and Confirm Password do not match.',
            ]);

            array_push($error_messages, [
                'confirm_password' => 'Password and Confirm Password do not match.',
            ]);
        }
    }

    if (sizeof($error_messages) > 0) {
        throw new Exception(json_encode($error_messages), 400);
    }

    // Begin the transaction
    $conn->beginTransaction();

    $profilePictureUrl = null;

    // Check if file is uploaded
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === 0) {
        $uploadDir = $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/phishshield/uploads/';
        // $fileName = basename($_FILES['profilePicture']['name']);

        $fileInfo = pathinfo($_FILES['profilePicture']['name']);
        $extension = $fileInfo['extension'];

        $newFileName = uniqid('profile_', true) . '.' . $extension;
        $uploadFilePath = $uploadDir . $newFileName;

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $uploadFilePath)) {
            $profilePictureUrl = $newFileName;
        } else {
            throw new Exception('No image was uploaded or there was an error in the upload process.', 500);
        }
    }

    // Update user account
    $query = "UPDATE accounts SET username = :username, display_name = :display_name";

    if (!empty($_POST['password'])) {
        $query .= ", password = :password";
    }

    if (!is_null($profilePictureUrl)) {
        $query .= ", profile = :profile";
    }

    $query .= " WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':user_id', $_POST['user_id']);
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':display_name', $_POST['display_name']);

    if (!empty($_POST['password'])) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);
    }

    if (!is_null($profilePictureUrl)) {
        $stmt->bindParam(':profile', $profilePictureUrl);
    }

    // Execute the query
    $stmt->execute();


    // Update user
    $query = "UPDATE users SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, email = :email WHERE id = :user_id";
    $stmt = $conn->prepare($query);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':user_id', $_POST['user_id']);
    $stmt->bindParam(':first_name', $_POST['first_name']);
    $stmt->bindParam(':middle_name', $_POST['middle_name']);
    $stmt->bindParam(':last_name', $_POST['last_name']);
    $stmt->bindParam(':email', $_POST['email']);

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
            'message' => $error->getMessage(),
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
