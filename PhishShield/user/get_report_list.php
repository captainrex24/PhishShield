<?php
include './database.php';

$report_list = [];

try {
    $query = "SELECT DISTINCT url, allowlist_website_id, blocklist_website_id FROM reports WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $_SESSION['ps_username']);

    $stmt->execute();
    $report_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
