<?php

$head = [
    'title' => 'Login',
    'route-name' => 'login',
    'style' => ['/user.css'],
    'script' => [
        '/user/script.js',
        '/user/login.js',
    ],
];

include './database.php';
include './parts/content_start.php';

if (isset($_SESSION['ps_user_id']) && isset($_SESSION['ps_username'])) {
    header("Location: home.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $query = "SELECT * FROM accounts WHERE username = :username AND role_id = 3";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['ps_account_id'] = $user['id'];
            $_SESSION['ps_user_id'] = $user['user_id'];
            $_SESSION['ps_username'] = $user['username'];
?>
            <script>
                window.location.reload()
            </script>
<?php
        } else {
            $error_message = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        // $error_message = "Database error: " . $e->getMessage();
        $error_message = "Something went wrong.";
    }
}

?>


<main class="container-fluid flex-grow-1" style="margin: 5% 0;">
    <div class="row">
        <div class="col-md-8 col-lg-5 col-xl-3 mx-auto position-relative">
            <!-- Start Profile Card -->
            <div class="card border-0 radius-0 form-wrapper">
                <div class="card-content">
                    <div class="card-body">
                        <div class="text-center mt-4 mb-5">
                            <h1 class="my-3">LOG IN</h1>
                        </div>
                        <form id="loginForm" class="mb-4" method="post" accept="#" autocomplete="off">
                            <!-- Username -->

                            <!-- Display error message if login fails -->
                            <?php if (!empty($error_message)) { ?>
                                <div class="error mx-auto mb-3 py-2 px-3"><?php echo $error_message; ?></div>
                            <?php } ?>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control radius-0 border-3 border-white bg-transparent" id="username" name="username" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="position-relative password-container">
                                    <input type="password" class="form-control radius-0 border-3 border-white bg-transparent" style="color: transparent;" id="password" name="password" value=" "
                                        required>
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

                            <div class="mb-3 text-center">
                                <a href="<?php echo $host . '/forgot-password.php' ?>" class="link-dark">Forgot password?</a>
                            </div>

                            <div class="mb-3 text-center">
                                <p class="mb-1">Have not yet account?</p>
                                <a href="<?php echo $host . '/register.php' ?>" class="link-dark">Register now!</a>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="primary-button">LOG IN</button>
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
