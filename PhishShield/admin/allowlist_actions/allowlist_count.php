<?php

$allowlist_count = 0;

try {
    // For new reports
    $query = "SELECT COUNT(*) FROM allowlist";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch the result
    $allowlist_count = $stmt->fetchColumn();
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
