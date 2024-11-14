<?php
$head = [
    'title' => 'Allow List',
    'route-name' => 'allowlist',
    'style' => ['/admin/style.css'],
    'script' => [
        '/admin/script.js',
        '/admin/allowlist.js'
    ],
];

include '../parts/admin_content_start.php';
include '../parts/summary_card.php';
include '../database.php';
include '../helpers/index.php';
include '../admin/allowlist_actions/allowlist_count.php';

?>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 col-12">
        <?php summary_card('Allowlist', $allowlist_count, '<i class="bi bi-clipboard-check fs-1"></i>') ?>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col">
        <?php if ($can_create) { ?>
            <!-- Start Add Website button -->
            <button type="button" class="primary-button bg-primary-100 text-white mb-4" style="text-transform: none;" data-bs-toggle="modal"
                data-bs-target="#addWebsiteModal">
                <i class="bi bi-plus-lg"></i>
                Add Website
            </button>
            <!-- End Add Website button -->
        <?php } ?>

        <!-- Start Table -->
        <table id="data_table" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>URL</th>
                    <th>Date Created</th>
                    <?php if ($can_update || $can_delete) { ?>
                        <th style="width: 10%;">Actions</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>URL</th>
                    <th>Date Created</th>
                    <?php if ($can_update || $can_delete) { ?>
                        <th>Actions</th>
                    <?php } ?>
                </tr>
            </tfoot>
        </table>
        <!-- End Table -->


        <?php if ($can_create) { ?>
            <!-- Start Add Website Modal -->
            <div class="modal fade" id="addWebsiteModal" tabindex="-1" aria-labelledby="addWebsiteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header border-0">
                            <h3 class="modal-title">Add Website</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body border-0">
                            <!-- Form Inside Modal -->
                            <form id="addWebsiteForm" action="<?php echo $host . '/admin/allowlist_actions/create.php' ?>" method='POST'>
                                <input type="hidden" class="d-none" id="account_id" name="account_id" value="<?php echo $admin_id ?>">
                                <input type="hidden" class="d-none" id="username" name="username" value="<?php echo $admin_username ?>">
                                <div class="mb-3">
                                    <label for="website_url" class="form-label">Website URL <span class="text-danger">*</span></label>
                                    <input type="url" class="bg-transparent" id="website_url" name="website_url"
                                        placeholder="https://example.com">
                                    <small class="error-message text-danger"></small>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer border-0">
                            <button type="button" class="primary-button bg-primary-50 text-white"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="addWebsiteForm"
                                class="primary-button bg-primary-100 text-white">Submit</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Add Website Modal -->
        <?php } ?>


        <?php if ($can_update) { ?>
            <!-- Start Edit Website Modal -->
            <div class="modal fade" id="editWebsiteModal" tabindex="-1" aria-labelledby="editWebsiteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header border-0">
                            <h3 class="modal-title">Edit Website</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body border-0">
                            <!-- Form Inside Modal -->
                            <form id="editWebsiteForm" action="<?php echo $host . '/admin/allowlist_actions/edit.php' ?>" method='POST'>
                                <input type="hidden" class="d-none" id="edit_website_id" name="edit_website_id">
                                <input type="hidden" class="d-none" id="edit_account_id" name="edit_account_id" value="<?php echo $admin_id ?>">
                                <div class="mb-3">
                                    <label for="edit_website_url" class="form-label">Website URL <span class="text-danger">*</span></label>
                                    <input type="url" class="bg-transparent" id="edit_website_url" name="edit_website_url"
                                        placeholder="https://example.com">
                                    <small class="error-message text-danger"></small>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_website_status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select id="edit_website_status" class="d-block w-100 bg-transparent" name="edit_website_status" aria-label="Default select example">
                                        <option value="" disabled>Select status</option>
                                        <option value="allowlist">Allowlist</option>
                                        <option value="blocklist">Blocklist</option>
                                    </select>
                                    <small class="error-message text-danger"></small>
                                </div>


                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer border-0">
                            <button type="button" class="primary-button bg-primary-50 text-white"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="editWebsiteForm" class="primary-button bg-primary-100 text-white">
                                Submit
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Edit Website Modal -->
        <?php } ?>


        <?php if ($can_delete) { ?>
            <!-- Start Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header border-0">
                            <h3 class="modal-title" id="deleteModalLabel">Confirm Deletion</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body border-0">
                            Are you sure you want to delete this website? This action cannot be undone.
                            <form id="deleteWebsiteForm" class="d-none" action="<?php echo $host . '/admin/allowlist_actions/delete.php' ?>" method='POST'>
                                <input type="text" class="form-control" id="delete_website_id"
                                    name="delete_website_id">
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer border-0">
                            <button type="button" class="primary-button bg-primary-50 text-white"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="deleteWebsiteForm"
                                class="primary-button bg-primary-100 text-white">Delete</button>
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
