<?php
$head = [
    'title' => 'Dashboard',
    'route-name' => 'dashboard',
    'script' => ['/admin/index.js'],
];

include '../parts/admin_content_start.php';
include '../parts/summary_card.php';
include '../admin/user_actions/user_count.php';
include '../admin/report_actions/report_count.php';
include '../admin/report_actions/report_graph_by_month.php';
include '../admin/allowlist_actions/allowlist_count.php';
include '../admin/blocklist_actions/blocklist_count.php';

?>

<!-- Summary Cards -->
<div class="row mb-4 justify-content-center">
    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <?php summary_card('New Reports', $report_count, '<i class="bi bi-globe fs-1"></i>') ?>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <?php summary_card('Allowlist', $allowlist_count, '<i class="bi bi-clipboard-check fs-1"></i>') ?>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <?php summary_card('Blocklist', $blocklist_count, '<i class="bi bi-clipboard-x fs-1"></i>') ?>
    </div>
</div>

<!-- Chart -->
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card bg-transparent border-0">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex justify-content-between">
                        <canvas id="reportedWebsitesChart" data-value='<?php echo json_encode($reported_website_graph_result) ?>'></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../parts/admin_content_end.php';
