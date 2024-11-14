<?php

$query = "SELECT * FROM reports WHERE allowlist_website_id IS NULL AND blocklist_website_id IS NULL ORDER BY created_at DESC";
$stmt = $conn->prepare($query);

try {
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $key => $value) {
?>
        <tr>
            <td class="pt-3">
                <a href="<?php echo $value['url'] ?>" target="_blank">
                    <?php echo $value['url'] ?>
                </a>
            </td>
            <td class="pt-3"><?php echo $value['username'] ?></td>
            <td class="pt-3"><?php echo dateFormat($value['created_at']) ?></td>
            <?php if ($can_update) { ?>
                <td>
                    <div>
                        <button type="button" data-url="<?php echo $host . '/admin/report_actions/allowlist.php' ?>" data-reported-url='<?php echo $value['url'] ?>' data-admin-id="<?php echo $admin_id ?>" class="btn btn-success allow-website-btn bg-transparent border-0"
                            data-tippy-content="Allow">
                            <i class="bi bi-check-circle"></i>
                        </button>
                        <button type="button" data-url="<?php echo $host . '/admin/report_actions/blocklist.php' ?>" data-reported-url='<?php echo $value['url'] ?>' data-admin-id="<?php echo $admin_id ?>" class="btn btn-danger block-website-btn bg-transparent border-0"
                            data-tippy-content="Block">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </td>
            <?php } ?>
        </tr>
<?php
    }
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
