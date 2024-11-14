<?php
$head = [
    'title' => 'Edit Profile',
    'route-name' => 'edit-profile',
    'style' => ['/user.css'],
    'script' => [
        '/user/script.js',
        '/user/profile.js',
    ],
];

include './parts/account_content_start.php';
?>

<div class="row">
    <div class="col">

        <form id="profileForm" action="<?php echo $host . '/user/edit_profile.php' ?>" method='POST' enctype="multipart/form-data">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['ps_user_id'] ?>">
            <input type="hidden" name="old_username" id="old_username" value="<?php echo $account_info['username'] ?>">

            <div class="mb-3">
                <img src="<?php echo $host . '/uploads/' . ($account_info['profile'] ?: 'user.png') ?>" alt="Profile" width="150" height="150"
                    id="previewProfilePicture" class="profile-picture rounded-circle me-2 object-fit-cover">
            </div>

            <!-- Profile Picture -->
            <div class="mb-3">
                <label for="profilePicture" class="form-label">Profile Picture</label>
                <input type="file" id="profilePicture" name="profilePicture" accept="image/*">
            </div>

            <div class="row">
                <!-- First Name -->
                <div class="col-4 mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" id="first_name"
                        name="first_name" value="<?php echo $account_info['first_name'] ?>" required>
                </div>

                <!-- Middle Name -->
                <div class="col-4 mb-3">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" id="middle_name"
                        name="middle_name" value="<?php echo $account_info['middle_name'] ?>">
                </div>

                <!-- Last Name -->
                <div class="col-4 mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" id="lastName"
                        name="last_name" value="<?php echo $account_info['last_name'] ?>" required>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email"
                    value="<?php echo $account_info['email'] ?>" required>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username"
                    value="<?php echo $account_info['username'] ?>" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="position-relative password-container">
                    <input type="password" id="password"
                        name="password">
                    <small class="error-message text-danger"></small>
                    <span role="button" class="password-eye position-absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </span>
                    <span role="button" class="password-eye-off position-absolute" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                            <line x1="1" y1="1" x2="23" y2="23" />
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <div class="position-relative confirm-password-container">
                    <input type="password" id="confirm_password"
                        name="confirm_password">
                    <small class="error-message text-danger"></small>
                    <span role="button" class="password-eye position-absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </span>
                    <span role="button" class="password-eye-off position-absolute" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                            <line x1="1" y1="1" x2="23" y2="23" />
                        </svg>
                    </span>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <!-- Submit Button -->
                <button type="submit" class="primary-button">Save Changes</button>
                <a href="<?php echo $host . '/profile.php' ?>" class="primary-button" style="background-color: transparent;">Cancel</a>
            </div>
        </form>

    </div>
</div>

<?php
include './parts/account_content_end.php';
