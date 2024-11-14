<?php

$report_count = 0;

try {
    // For new reports
    $query = "SELECT COUNT(*) FROM reports WHERE allowlist_website_id IS NULL AND blocklist_website_id IS NULL";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch the result
    $report_count = $stmt->fetchColumn();
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
