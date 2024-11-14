<?php
include '../database.php';
include '../methods/post.php';

header('Content-Type: application/json');

try {
    $required_fields = ['user_id', 'rating', 'review'];
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

    $query = "INSERT INTO reviews (account_id, message, rating) VALUES (:account_id, :message, :rating)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':account_id', $data['user_id']);
    $stmt->bindParam(':message', $data['review']);
    $stmt->bindParam(':rating', $data['rating']);

    $stmt->execute();

    $response = [
        'status' => 'success',
        'message' => 'Review added successfully!',
    ];

    http_response_code(201);
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
