<?php
include './database.php';

$review_list = [];

try {
    $query = "SELECT reviews.*, accounts.display_name, accounts.profile FROM reviews JOIN accounts ON reviews.account_id = accounts.id";
    $stmt = $conn->prepare($query);

    $stmt->execute();
    $review_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
