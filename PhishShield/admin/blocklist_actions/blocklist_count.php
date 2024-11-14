<?php

$blocklist_count = 0;

try {
    // For new reports
    $query = "SELECT COUNT(*) FROM blocklist";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch the result
    $blocklist_count = $stmt->fetchColumn();
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
