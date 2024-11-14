<?php
include '../../database.php';
include '../../helpers/index.php';

// Error reporting for debugging
ini_set('display_errors', 0);

// Set Content-Type header
header('Content-Type: application/json');

// Parameters from DataTables
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 0;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;
$search = $_GET['search']['value'] ?? '';
$orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
$orderDir = $_GET['order'][0]['dir'] ?? 'asc';

// Define column mapping based on your table columns
$columns = ['url', 'created_at'];
$orderColumn = $columns[$orderColumnIndex] ?? $columns[0];

// Use SQL_CALC_FOUND_ROWS for efficient pagination
$query = "SELECT SQL_CALC_FOUND_ROWS url, created_at, id FROM allowlist WHERE 1=1";

// Add search condition if search term is present
if (!empty($search)) {
    $query .= " AND url LIKE :search";
}

// Add ordering and pagination
$query .= " ORDER BY $orderColumn $orderDir LIMIT :start, :length";

// Prepare and execute query
$stmt = $conn->prepare($query);
if (!empty($search)) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}
$stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
$stmt->bindValue(':length', (int) $length, PDO::PARAM_INT);
$stmt->execute();

// Fetch data
$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nestedData = [
        'url' => '<a href="' . htmlspecialchars($row['url'], ENT_QUOTES) . '" class="pe-none" target="_blank">' . htmlspecialchars($row['url'], ENT_QUOTES) . '</a>',
        'created_at' => dateFormat($row['created_at'])
    ];

    // Prepare actions with JSON-safe encoding
    $websiteData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
    $nestedData['actions'] = '<button class="btn btn-primary edit-website-btn bg-transparent border-0" data-website=\'' . $websiteData . '\' onclick="editWebsiteHandler(this)" data-tippy-content="Edit" data-bs-toggle="modal" data-bs-target="#editWebsiteModal"><i class="bi bi-pencil"></i></button>'
        . '<button class="btn btn-danger delete-website-btn bg-transparent border-0" data-website-id="' . htmlspecialchars($row['id'], ENT_QUOTES) . '" onclick="deleteWebsiteHandler(this)" data-tippy-content="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash3"></i></button>';
    $data[] = $nestedData;
}

// Get total filtered and unfiltered record counts
$totalFiltered = $conn->query("SELECT FOUND_ROWS()")->fetchColumn();
$totalData = empty($search) ? $totalFiltered : $conn->query("SELECT COUNT(*) FROM allowlist")->fetchColumn();

// JSON response for DataTables
$response = [
    "draw" => $draw,
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

echo json_encode($response);
