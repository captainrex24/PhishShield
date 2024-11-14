<?php
$head = [
    'title' => 'Users',
    'route-name' => 'users',
    'style' => ['/admin/style.css'],
    'script' => [
        '/admin/script.js',
        '/admin/users.js',
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
                data-bs-target="#addUserModal">
                <i class="bi bi-plus-lg"></i>
                Add User
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
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email Address</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Date Created</th>
                                <?php if ($can_update || $can_delete) { ?>
                                    <th style="width: 10%;">Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include 'user_actions/get.php' ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email Address</th>
                                <th>Username</th>
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
            <!-- Start Add User Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form id="addUserForm" action="<?php echo $host . '/admin/user_actions/create.php' ?>" method='POST'>
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first_name"
                                            name="first_name">
                                        <small class="error-message text-danger"></small>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" id="middle_name"
                                            name="middle_name">
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last_name"
                                            name="last_name">
                                        <small class="error-message text-danger"></small>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email">
                                    <small class="error-message text-danger"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="username"
                                        name="username">
                                    <small class="error-message text-danger"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="password"
                                        name="password">
                                    <small class="error-message text-danger"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="display_name" class="form-label">Display Name</label>
                                    <input type="text" class="form-control" id="display_name"
                                        name="display_name">
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select" id="role" name="role">
                                        <option value="" selected disabled>Select role</option>
                                        <?php include 'user_actions/roles.php' ?>
                                    </select>
                                    <small class="error-message text-danger"></small>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="addUserForm" class="btn btn-primary">Add
                                User</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Add User Modal -->
        <?php } ?>


        <?php if ($can_update) { ?>
            <!-- Start Edit User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1"
                aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form id="editUserForm" action="<?php echo $host . '/admin/user_actions/edit.php' ?>" method='POST'>
                                <input type="hidden" id="edit_user_id" name="edit_user_id" value="">
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label for="edit_first_name" class="form-label">First
                                            Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit_first_name"
                                            name="first_name">
                                        <small class="error-message text-danger"></small>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="edit_middle_name" class="form-label">Middle
                                            Name</label>
                                        <input type="text" class="form-control" id="edit_middle_name"
                                            name="middle_name">
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="edit_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit_last_name"
                                            name="last_name">
                                        <small class="error-message text-danger"></small>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="edit_email"
                                        name="email">
                                    <small class="error-message text-danger"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_username"
                                        name="username">
                                    <small class="error-message text-danger"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="edit_password"
                                        name="password">
                                    <small class="error-message text-danger"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_display_name" class="form-label">Display
                                        Name</label>
                                    <input type="text" class="form-control" id="edit_display_name"
                                        name="display_name">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_role" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_role" name="edit_role" required>
                                        <option value="" disabled>Select role</option>
                                        <?php include 'user_actions/roles.php' ?>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="editUserForm" class="btn btn-primary">Save
                                Changes</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Edit User Modal -->
        <?php } ?>

        <?php if ($can_delete) { ?>
            <!-- Start Delete Confirmation Modal -->
            <div class="modal fade" id="deleteUserModal" tabindex="-1"
                aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <p>
                                Are you sure you want to delete the user <strong id="deleteUserName">John
                                    Smith</strong>? This action cannot be undone.
                            </p>
                            <form id="deleteUserForm" class="d-none" action="<?php echo $host . '/admin/user_actions/delete.php' ?>" method='POST'>
                                <input type="text" class="form-control" id="delete_user_id"
                                    name="delete_user_id">
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="deleteUserForm"
                                class="btn btn-danger">Delete User</button>
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
