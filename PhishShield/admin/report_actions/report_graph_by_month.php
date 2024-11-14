<?php

try {
    $query = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS report_month, COUNT(*) AS report_count FROM reports WHERE YEAR(created_at) = YEAR(CURDATE()) GROUP BY report_month ORDER BY report_month ASC;";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch the result
    $reported_website_graph_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
