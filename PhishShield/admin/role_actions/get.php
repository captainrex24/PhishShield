<?php

$query = "SELECT * FROM roles WHERE id != 1 ORDER BY created_at DESC";
$stmt = $conn->prepare($query);

try {
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $key => $value) {
?>
        <tr>
            <td class="pt-3"><?php echo $value['role_name'] ?></td>
            <td class="pt-3"><?php echo dateFormat($value['created_at']) ?></td>
            <?php if ($can_update || $can_delete) { ?>
                <td>
                    <div>
                        <?php if ($can_update) { ?>
                            <button type="button" data-url="<?php echo $host . '/admin/role_actions/get_permission_by_id.php' ?>" data-role='<?php echo json_encode($value) ?>' class="btn btn-primary edit-role-btn"
                                data-tippy-content="Edit" data-bs-toggle="modal"
                                data-bs-target="#editRoleModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                        <?php } ?>

                        <?php if ($can_delete) { ?>
                            <button type="button" data-role-id="<?php echo $value['id'] ?>" data-role-name="<?php echo $value['role_name'] ?>" class="btn btn-danger delete-role-btn"
                                data-tippy-content="Delete" data-bs-toggle="modal"
                                data-bs-target="#deleteRoleModal">
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
