<?php

$query = "SELECT a.id, a.user_id, a.role_id, a.username, a.display_name, a.created_at, u.first_name, u.middle_name, u.last_name, u.email, r.role_name FROM accounts a JOIN users u ON a.user_id = u.id JOIN roles r ON a.role_id = r.id WHERE a.id != 1 ORDER BY a.created_at DESC";
$stmt = $conn->prepare($query);

try {
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $key => $value) {
?>
        <tr>
            <td class="pt-3"><?php echo $value['first_name'] ?></td>
            <td class="pt-3"><?php echo $value['last_name'] ?></td>
            <td class="pt-3"><?php echo $value['email'] ?></td>
            <td class="pt-3"><?php echo $value['username'] ?></td>
            <td class="pt-3"><?php echo $value['role_name'] ?></td>
            <td class="pt-3"><?php echo dateFormat($value['created_at']) ?></td>
            <?php if ($can_update || $can_delete) { ?>
                <td>
                    <div>
                        <?php if ($can_update) { ?>
                            <button type="button" data-user='<?php echo json_encode($value) ?>' class="btn btn-primary edit-user-btn"
                                data-tippy-content="Edit" data-bs-toggle="modal"
                                data-bs-target="#editUserModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                        <?php } ?>

                        <?php if ($can_delete) { ?>
                            <button type="button" data-user-id="<?php echo $value['user_id'] ?>" data-user-name="<?php echo $value['username'] ?>" class="btn btn-danger delete-user-btn"
                                data-tippy-content="Delete" data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal">
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
