<?php
include '../../database.php';
include '../../helpers/index.php';

// Disable error reporting for production
ini_set('display_errors', 1);
header('Content-Type: application/json');

// DataTables parameters
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 0;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;
$search = $_GET['search']['value'] ?? '';
$orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
$orderDir = $_GET['order'][0]['dir'] ?? 'asc';

// Column mapping for ordering
$columns = ['url', 'username', 'created_at'];
$orderColumn = $columns[$orderColumnIndex] ?? $columns[0];

// Total records without filtering
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM reports WHERE allowlist_website_id IS NULL AND blocklist_website_id IS NULL");
$totalData = $totalQuery->fetch(PDO::FETCH_ASSOC)['total'];

// Build query with search filtering
$query = "SELECT * FROM reports WHERE allowlist_website_id IS NULL AND blocklist_website_id IS NULL";
if (!empty($search)) {
    $query .= " AND (url LIKE :search OR username LIKE :search)";
}

// Total records with filtering
$stmt = $conn->prepare($query);
if (!empty($search)) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}
$stmt->execute();
$totalFiltered = $stmt->rowCount();

// Apply ordering and pagination
$query .= " ORDER BY " . $orderColumn . " $orderDir LIMIT :start, :length";
$stmt = $conn->prepare($query);

if (!empty($search)) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}
$stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
$stmt->bindValue(':length', (int) $length, PDO::PARAM_INT);
$stmt->execute();

$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nestedData = [];
    $nestedData['url'] = '<a href="' . htmlspecialchars($row['url'], ENT_QUOTES) . '" class="pe-none" target="_blank">' . htmlspecialchars($row['url'], ENT_QUOTES) . '</a>';
    $nestedData['username'] = htmlspecialchars($row['username'], ENT_QUOTES);
    $nestedData['created_at'] = dateFormat($row['created_at']);

    $actions = '<div>';
    $actions .= '<button type="button" data-url="' . 'http://localhost/phishshield/admin/report_actions/allowlist.php" data-reported-url=\'' . htmlspecialchars($row['url'], ENT_QUOTES) . '\' class="btn btn-success allow-website-btn bg-transparent border-0" onclick="allowlistHandler(this)" data-tippy-content="Allow"><i class="bi bi-check-circle"></i></button>';
    $actions .= '<button type="button" data-url="' . 'http://localhost/phishshield/admin/report_actions/blocklist.php" data-reported-url=\'' . htmlspecialchars($row['url'], ENT_QUOTES) . '\' class="btn btn-danger block-website-btn bg-transparent border-0" onclick="blocklistHandler(this)" data-tippy-content="Block"><i class="bi bi-x-circle"></i></button>';
    $actions .= '</div>';
    $nestedData['actions'] = $actions;

    $data[] = $nestedData;
}

// JSON response for DataTables
$response = [
    "draw" => $draw,
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

echo json_encode($response);
