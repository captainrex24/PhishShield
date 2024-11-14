<?php

$databaseHost = 'localhost';
$databaseName = 'phishshield';
$username = 'root';
$password = '';

$modules = ['reports', 'allowlist', 'blocklist', 'users', 'roles'];
$actions = ['create', 'read', 'update', 'delete'];

try {
    $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    die('Connection failed:' . $error->getMessage());
}
