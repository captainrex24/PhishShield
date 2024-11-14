<?php
$head = [
    'title' => 'Register',
    'route-name' => 'register',
    'style' => ['/user.css'],
    'script' => [
        '/user/script.js',
        '/user/register.js',
    ],
];


include './parts/content_start.php';
?>


<main class="container-fluid flex-grow-1" style="margin: 3% 0;">
    <div class="row">
        <div class="col-md-8 col-lg-5 col-xl-5 mx-auto position-relative">
            <!-- Start Profile Card -->
            <div class="card border-0 radius-0 form-wrapper">
                <div class="card-content">
                    <div class="card-body">
                        <div class="text-center mt-4 mb-5">
                            <h1 class="my-3">CREATE AN ACCOUNT</h1>
                        </div>
                        <form id="registerForm" class="mb-4" action="<?php echo $host . '/user/register.php' ?>" method='POST'>
                            <div class="row">
                                <!-- First Name -->
                                <div class="col-4 mb-3">
                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control radius-0 border-3 border-white bg-transparent" id="first_name" name="first_name">
                                    <small class="error-message text-danger"></small>
                                </div>

                                <!-- Middle Name -->
                                <div class="col-4 mb-3">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control radius-0 border-3 border-white bg-transparent" id="middle_name" name="middle_name">
                                </div>

                                <!-- Last Name -->
                                <div class="col-4 mb-3">
                                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control radius-0 border-3 border-white bg-transparent" id="last_name" name="last_name">
                                    <small class="error-message text-danger"></small>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control radius-0 border-3 border-white bg-transparent" id="email" name="email">
                                <small class="error-message text-danger"></small>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-0 border-3 border-white bg-transparent" id="username" name="username">
                                <small class="error-message text-danger"></small>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="position-relative password-container">
                                    <input type="password" class="form-control radius-0 border-3 border-white bg-transparent" style="color: transparent;" id="password" name="password" value=" ">
                                    <small class="error-message text-danger"></small>
                                    <span role="button" class="password-eye position-absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mb-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </span>
                                    <span role="button" class="password-eye-off position-absolute" style="display: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mb-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                            <line x1="1" y1="1" x2="23" y2="23" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <div class="position-relative confirm-password-container">
                                    <input type="password" class="form-control radius-0 border-3 border-white bg-transparent" id="confirm_password" name="confirm_password">
                                    <small class="error-message text-danger"></small>
                                    <span role="button" class="password-eye position-absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mb-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </span>
                                    <span role="button" class="password-eye-off position-absolute" style="display: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mb-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                            <line x1="1" y1="1" x2="23" y2="23" />
                                        </svg>
                                    </span>
                                </div>
                            </div>


                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="primary-button">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php
include './parts/content_end.php';
