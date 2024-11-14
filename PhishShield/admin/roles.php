<?php
$head = [
    'title' => 'Roles',
    'route-name' => 'roles',
    'style' => ['/admin/style.css'],
    'script' => [
        '/admin/script.js',
        '/admin/roles.js',
    ],
];

include '../parts/admin_content_start.php';
include '../parts/summary_card.php';
include '../database.php';
include '../helpers/index.php';
include '../admin/user_actions/user_count.php';

?>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 col-12">
        <?php summary_card('Users', $user_count, '<i class="bi bi-people fs-1"></i>') ?>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col">
        <?php if ($can_create) { ?>
            <!-- Start Add User button -->
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal"
                data-bs-target="#addRoleModal">
                <i class="bi bi-plus-lg"></i>
                Add Role
            </button>
            <!-- End Add User button -->
        <?php } ?>


        <!-- Start Table Card -->
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Date Created</th>
                                <?php if ($can_update || $can_delete) { ?>
                                    <th style="width: 10%;">Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include 'role_actions/get.php' ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Role</th>
                                <th>Date Created</th>
                                <?php if ($can_update || $can_delete) { ?>
                                    <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Table Card -->

        <?php if ($can_create) { ?>
            <!-- Start Add Role Modal -->
            <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form id="addRoleForm" action="<?php echo $host . '/admin/role_actions/create.php' ?>" method='POST'>
                                <div class="mb-3">
                                    <label for="role_name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="role_name"
                                        name="role_name">
                                    <small class="error-message text-danger"></small>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="addRoleForm" class="btn btn-primary">
                                Add Role
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Add Role Modal -->
        <?php } ?>


        <?php if ($can_update) { ?>
            <!-- Start Edit User Modal -->
            <div class="modal fade" id="editRoleModal" tabindex="-1"
                aria-labelledby="editRoleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRoleModalLabel">Edit Role Permissions</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form id="editRoleForm" action="<?php echo $host . '/admin/role_actions/edit.php' ?>" method='POST'>
                                <input type="hidden" id="edit_role_id" name="role_name" value="">
                                <div class="mb-3">
                                    <label for="edit_role_name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_role_name"
                                        name="role_name">
                                    <small class="error-message text-danger"></small>
                                </div>

                                <!-- Module: Reports -->
                                <div class="module-permissions">
                                    <label>Reports</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="reports_create" name="reports_create">
                                        <label class="form-check-label"
                                            for="reports_create">Create</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="reports_read" name="reports_read">
                                        <label class="form-check-label" for="reports_read">Read</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="reports_update" name="reports_update">
                                        <label class="form-check-label"
                                            for="reports_update">Update</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="reports_delete" name="reports_delete">
                                        <label class="form-check-label"
                                            for="reports_delete">Delete</label>
                                    </div>
                                </div>

                                <!-- Module: Allowlist -->
                                <div class="module-permissions">
                                    <label>Allowlist</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="allowlist_create" name="allowlist_create">
                                        <label class="form-check-label"
                                            for="allowlist_create">Create</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="allowlist_read" name="allowlist_read">
                                        <label class="form-check-label"
                                            for="allowlist_read">Read</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="allowlist_update" name="allowlist_update">
                                        <label class="form-check-label"
                                            for="allowlist_update">Update</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="allowlist_delete" name="allowlist_delete">
                                        <label class="form-check-label"
                                            for="allowlist_delete">Delete</label>
                                    </div>
                                </div>

                                <!-- Module: Blocklist -->
                                <div class="module-permissions">
                                    <label>Blocklist</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="blocklist_create" name="blocklist_create">
                                        <label class="form-check-label"
                                            for="blocklist_create">Create</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="blocklist_read" name="blocklist_read">
                                        <label class="form-check-label"
                                            for="blocklist_read">Read</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="blocklist_update" name="blocklist_update">
                                        <label class="form-check-label"
                                            for="blocklist_update">Update</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="blocklist_delete" name="blocklist_delete">
                                        <label class="form-check-label"
                                            for="blocklist_delete">Delete</label>
                                    </div>
                                </div>

                                <!-- Module: Users -->
                                <div class="module-permissions">
                                    <label>Users</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="users_create" name="users_create">
                                        <label class="form-check-label"
                                            for="users_create">Create</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="users_read"
                                            name="users_read">
                                        <label class="form-check-label" for="users_read">Read</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="users_update" name="users_update">
                                        <label class="form-check-label"
                                            for="users_update">Update</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="users_delete" name="users_delete">
                                        <label class="form-check-label"
                                            for="users_delete">Delete</label>
                                    </div>
                                </div>

                                <!-- Module: Roles -->
                                <div class="module-permissions">
                                    <label>Roles</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="roles_create" name="roles_create">
                                        <label class="form-check-label"
                                            for="roles_create">Create</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="roles_read"
                                            name="roles_read">
                                        <label class="form-check-label" for="roles_read">Read</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="roles_update" name="roles_update">
                                        <label class="form-check-label"
                                            for="roles_update">Update</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="roles_delete" name="roles_delete">
                                        <label class="form-check-label"
                                            for="roles_delete">Delete</label>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="editRoleForm" class="btn btn-primary">Save
                                Changes</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Edit User Modal -->
        <?php } ?>


        <?php if ($can_delete) { ?>
            <!-- Start Delete Confirmation Modal -->
            <div class="modal fade" id="deleteRoleModal" tabindex="-1"
                aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteRoleModalLabel">Confirm Delete Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <p>Are you sure you want to delete the role <strong
                                    id="deleteRoleName">Admin</strong>? This action cannot be undone,
                                and users assigned to this role will need to be reassigned.</p>
                            <form id="deleteRoleForm" class="d-none" action="<?php echo $host . '/admin/role_actions/delete.php' ?>" method='POST'>
                                <input type="text" class="form-control" id="delete_role_id"
                                    name="delete_role_id">
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="deleteRoleForm"
                                class="btn btn-danger">Delete Role</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Delete Confirmation Modal -->
        <?php } ?>

    </div>
</div>
<?php
include '../parts/admin_content_end.php';
