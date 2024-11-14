<?php
$query = "SELECT * FROM accounts JOIN users ON accounts.user_id = users.id JOIN roles ON accounts.role_id = roles.id WHERE accounts.id = :account_id";
$stmt = $conn->prepare($query);

try {
    $stmt->bindParam(':account_id', $admin_id);
    $stmt->execute();
    $account_info = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
