<?php
$head = [
    'title' => 'Profile',
    'route-name' => 'profile',
    'style' => ['/user.css'],
    'script' => [
        '/user/profile.js',
    ],
];

include './parts/account_content_start.php';
?>

<div class="row">
    <div class="col">

        <!-- Start Profile Card -->
        <form id="profileForm">

            <a href="<?php echo $host . '/edit-profile.php' ?>" class="primary-button rounded-circle edit-button"
                data-tippy-content="Edit">
                <i class="bi bi-pencil"></i>
            </a>

            <div class="mb-3">
                <img src="<?php echo $host . '/uploads/' . ($account_info['profile'] ?: 'user.png') ?>" alt="Profile" width="150" height="150"
                    class="profile-picture rounded-circle me-2 object-fit-cover">
            </div>

            <div class="row">
                <!-- First Name -->
                <div class="col-4 mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" id="firstName" name="first_name"
                        value="<?php echo $account_info['first_name'] ?>" required disabled>
                </div>

                <!-- Middle Name -->
                <div class="col-4 mb-3">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name"
                        value="<?php echo $account_info['middle_name'] ?>" disabled>
                </div>

                <!-- Last Name -->
                <div class="col-4 mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" id="last_name" name="last_name"
                        value="<?php echo $account_info['last_name'] ?>" required disabled>
                </div>
            </div>


            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email"
                    value="<?php echo $account_info['email'] ?>" required disabled>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username"
                    value="<?php echo $account_info['username'] ?>" required disabled>
            </div>
        </form>
        <!-- End Profile Card -->

        <!-- Start Profile Card -->
        <div class="card d-none">
            <div class="card-content">
                <div class="card-body">
                    <form id="profileForm">
                        <div class="mb-3">
                            <img src="/assets/user.png" alt="Profile" width="150" height="150"
                                class="rounded-circle me-2 bor">
                        </div>

                        <!-- Profile Picture -->
                        <div class="mb-3">
                            <label for="profilePicture" class="form-label">Profile Picture</label>
                            <input type="file" id="profilePicture"
                                accept="image/*">
                        </div>

                        <div class="row">
                            <!-- First Name -->
                            <div class="col-4 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" id="firstName"
                                    name="first_name" value="John" required>
                            </div>

                            <!-- Middle Name -->
                            <div class="col-4 mb-3">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <input type="text" id="middleName"
                                    name="middle_name" value="Santos">
                            </div>

                            <!-- Last Name -->
                            <div class="col-4 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" id="lastName"
                                    name="last_name" value="Smith" required>
                            </div>
                        </div>



                        <div class="row">
                            <!-- Contact Number -->
                            <div class="col-6 mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="text" id="contactNumber"
                                    name="contact_number" value="9123456789" required>
                            </div>

                            <!-- Email -->
                            <div class="col-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email"
                                    value="john@example.com" required>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username"
                                value="john_smith" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password"
                                name="password" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm
                                Password</label>
                            <input type="password" id="confirm_password"
                                name="confirm_password" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Profile Card -->




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
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmDeleteRoleBtn"
                            class="btn btn-danger">Delete User</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Delete Confirmation Modal -->

    </div>
</div>

<?php
include './parts/account_content_end.php';
