<?php
$head = [
    'title' => 'Report List',
    'route-name' => 'report-list',
    'style' => ['/user.css'],
    'script' => [
        '/user/report-list.js',
    ],
];

include './parts/account_content_start.php';
include './user/get_report_list.php';


?>

<div id="report_list">
    <div class="row">
        <div class="col-8">
            <div class="bg-primary-50 px-5 py-5">
                <h3 class="text-center m-0">URL REPORTS</h3>
            </div>
        </div>
        <div class="col-4">
            <div class="bg-primary-50 px-5 py-5">
                <h3 class="text-center m-0">STATUS</h3>
            </div>
        </div>
    </div>

    <?php foreach ($report_list as $list => $value) { ?>
        <div class="row">
            <div class="col-8">
                <div class="bg-primary-50 px-5 pb-3">
                    <p><?php echo $value['url'] ?></p>
                </div>
            </div>
            <div class="col-4">
                <div class="bg-primary-50 px-5 pb-3">
                    <?php if (!is_null($value['allowlist_website_id'])) { ?>
                        <p class="text-center" style="color: var(--green-color)">SAFE</p>
                    <?php } elseif (!is_null($value['blocklist_website_id'])) { ?>
                        <p class="text-center" style="color: var(--red-color)">MALICIOUS</p>
                    <?php } else { ?>
                        <p class="text-center" style="color: var(--yellow-color)">SUSPICIOUS</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php
include './parts/account_content_end.php';
