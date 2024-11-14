<?php

$user_count = 0;

try {
    $query = "SELECT COUNT(*) FROM users WHERE id != 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch the result
    $user_count = $stmt->fetchColumn();
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
