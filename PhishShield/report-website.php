<?php
$head = [
    'title' => 'Report Website',
    'route-name' => 'report-website',
    'style' => ['/user.css'],
    'script' => [
        '/user/script.js',
        '/user/home.js',
    ],
];

require './database.php';
include './parts/content_start.php';
require './user/virus-total.php';

if (!isset($_SESSION['ps_username']) || !isset($_GET['report_url']) || empty($_GET['report_url'])) {
    header("Location: login.php", true, 301);
    exit;
}

try {
    // Begin the transaction
    $conn->beginTransaction();

    $query = "INSERT INTO reports (url, username) VALUES (:url, :username)";
    $stmt = $conn->prepare($query);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':url', $_GET['report_url']);
    $stmt->bindParam(':username', $_SESSION['ps_username']);

    // Execute the query
    $stmt->execute();

    // AUTOMATE REPORTING OF SUSPICIOUS WEBSITE
    // if (json_decode(getUrlReport($_GET['report_url']))->data->malicious > 0) {
    //     $query = "INSERT INTO blocklist (url) VALUES (:url)";
    //     $stmt = $conn->prepare($query);

    //     // Bind parameters to prevent SQL injection
    //     $stmt->bindParam(':url', $_GET['report_url']);

    //     // Execute the query
    //     $stmt->execute();

    //     $blocklist_id = $conn->lastInsertId();

    //     // All reported websites with the same url will be updated
    //     $query = "UPDATE reports SET blocklist_website_id = :blocklist_id WHERE url = :url";
    //     $stmt = $conn->prepare($query);

    //     // Bind parameters to prevent SQL injection
    //     $stmt->bindParam(':url', $_GET['report_url']);
    //     $stmt->bindParam(':blocklist_id', $blocklist_id);

    //     // Execute the query
    //     $stmt->execute();
    // } else {
    //     $query = "INSERT INTO allowlist (url) VALUES (:url)";
    //     $stmt = $conn->prepare($query);

    //     // Bind parameters to prevent SQL injection
    //     $stmt->bindParam(':url', $_GET['report_url']);

    //     // Execute the query
    //     $stmt->execute();

    //     $allowlist_id = $conn->lastInsertId();

    //     // All reported websites with the same url will be updated
    //     $query = "UPDATE reports SET allowlist_website_id = :allowlist_id WHERE url = :url";
    //     $stmt = $conn->prepare($query);

    //     // Bind parameters to prevent SQL injection
    //     $stmt->bindParam(':url', $_GET['report_url']);
    //     $stmt->bindParam(':allowlist_id', $allowlist_id);

    //     // Execute the query
    //     $stmt->execute();
    // }

    // Commit the transaction
    $conn->commit();
} catch (PDOException $error) {
    // Rollback if the transaction is still active
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
}


?>

<main class="container-fluid flex-grow-1">
    <section class="text-center mx-auto" style="max-width: 768px; margin: 14% 0;">
        <p>Thank you for reporting this site. Your submission has been received and is currently under review. Please allow some time for approval and further action.</p>
    </section>
</main>

<?php
include './parts/content_end.php';
