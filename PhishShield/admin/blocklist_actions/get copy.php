<?php

$query = "SELECT b.*, u.first_name, u.last_name FROM blocklist b JOIN accounts a ON a.id = b.approved_by JOIN users u ON a.user_id = u.id ORDER BY b.created_at DESC";
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
            <td class="pt-3"><?php echo $value['first_name'] . ' ' . $value['last_name'] ?></td>
            <td class="pt-3"><?php echo dateFormat($value['created_at']) ?></td>
            <?php if ($can_update || $can_delete) { ?>
                <td>
                    <div>
                        <?php
                        if ($can_update) { ?>
                            <button type="button" class="btn btn-primary edit-website-btn bg-transparent border-0" data-website='<?php echo json_encode($value) ?>'
                                data-tippy-content="Edit" data-bs-toggle="modal"
                                data-bs-target="#editWebsiteModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                        <?php
                        }
                        if ($can_delete) { ?>
                            <button type="button" class="btn btn-danger delete-website-btn bg-transparent border-0" data-website-id="<?php echo $value['id'] ?>"
                                data-tippy-content="Delete" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="bi bi-trash3"></i>
                            </button>
                        <?php } ?>
                    </div>
                </td>
            <?php } ?>
        </tr>
<?php
    }
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
