<?php

include '../database.php';
include '../methods/get.php';

// Check if 'url' is provided in the GET request
if (isset($_GET['url']) && !empty($_GET['url'])) {
    // Sanitize the URL
    $url = filter_var($_GET['url'], FILTER_SANITIZE_URL);

    // Validate the URL
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $query = "SELECT * FROM blacklist WHERE url LIKE :url";
        $stmt = $conn->prepare($query);

        try {
            
            // Execute the query with the dynamic URL parameter
            $stmt->execute([
                'url' => $url,
            ]);

            // Fetch the results
            $reportedUrls = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare the response
            $response = [
                'status' => 'success',
                'message' => 'URL fetched successfully',
                'data' => $reportedUrls
            ];

            // Send JSON response
            echo json_encode($response);
        } catch (PDOException $error) {
            // Handle any database exceptions
            $response = [
                'status' => 'error',
                'message' => 'Failed to fetch URL: ' . $error->getMessage(),
            ];

            http_response_code(500); // Set the appropriate status code
            echo json_encode($response);
        }
    } else {
        // Handle invalid URL input
        $response = [
            'status' => 'error',
            'message' => 'Invalid URL format provided',
        ];

        http_response_code(400); // Bad Request
        echo json_encode($response);
    }
} else {
    // Handle missing 'url' parameter
    $response = [
        'status' => 'error',
        'message' => 'URL parameter is required',
    ];

    http_response_code(400); // Bad Request
    echo json_encode($response);
}
