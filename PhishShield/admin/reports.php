<?php
$head = [
    'title' => 'Reports',
    'route-name' => 'reports',
    'style' => ['/admin/style.css'],
    'script' => [
        '/admin/script.js',
        '/admin/reports.js'
    ],
];

include '../parts/admin_content_start.php';
include '../parts/summary_card.php';
include '../database.php';
include '../helpers/index.php';
include '../admin/report_actions/report_count.php';
?>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 col-12">
        <?php summary_card('New Reports', $report_count, '<i class="bi bi-globe fs-1"></i>') ?>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col">
        <table id="data_table" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>URL</th>
                    <th>Username</th>
                    <th>Date Reported</th>
                   
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>URL</th>
                    <th>Username</th>
                    <th>Date Reported</th>
                  
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php
include '../parts/admin_content_end.php';
