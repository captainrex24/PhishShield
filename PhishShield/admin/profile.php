<?php
$head = [
    'title' => 'Profile',
    'route-name' => 'profile',
];

include '../parts/admin_content_start.php';
include '../admin/profile_actions/get.php';
?>

<div class="row">
    <div class="col">

        <!-- Start Profile Card -->
        <form id="profileForm">

            <a href="<?php echo $host . '/admin/edit-profile.php' ?>" class="primary-button rounded-circle edit-button"
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
                        value="<?php echo $account_info['first_name'] ?>" disabled>
                </div>

                <!-- Middle Name -->
                <div class="col-4 mb-3">
                    <label for="middleName" class="form-label">Middle Name</label>
                    <input type="text" id="middleName" name="middle_name"
                        value="<?php echo $account_info['middle_name'] ?>" disabled>
                </div>

                <!-- Last Name -->
                <div class="col-4 mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" id="lastName" name="last_name"
                        value="<?php echo $account_info['last_name'] ?>" disabled>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email"
                    value="<?php echo $account_info['email'] ?>" disabled>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username"
                    value="<?php echo $account_info['username'] ?>" disabled>
            </div>

            <!-- Display Name -->
            <div class="mb-3">
                <label for="displayName" class="form-label">Display Name</label>
                <input type="text" id="displayName" name="display_name"
                    value="<?php echo $account_info['display_name'] ?>" disabled>
            </div>

            <!-- Role (Cannot be edited) -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" id="role" name="role" value="<?php echo $account_info['role_name'] ?>" readonly
                    disabled>
            </div>
        </form>
        <!-- End Profile Card -->
    </div>
</div>

<?php
include '../parts/admin_content_end.php';
