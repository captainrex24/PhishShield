<?php
$host = 'http://' . $_SERVER['HTTP_HOST'] . '/phishshield';

$head = [
    'title' => 'Login'
];

include '../database.php';

session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $query = "SELECT * FROM accounts WHERE username = :username AND role_id != 3";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['display_name'] = $user['display_name'];
            $_SESSION['role_id'] = $user['role_id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error_message = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
        // $error_message = "Something went wrong.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $host . '/style/style.css' ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title><?php echo $head['title'] ?></title>
    <link rel="stylesheet" href="<?php echo $host . '/style/admin/style.css' ?>" />
    <style>
        body {
            background-color: #F0F2F9;
            font-family: "Archivo Black", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 20px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 40%;
            background-attachment: fixed;
            display: grid;
        }

        body:before {
            content: '';
            position: fixed;
            inset: 0;
            background-color: rgba(255, 255, 255, 0.5);
            z-index: -1;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body style="background-image: url('<?php echo $host . '/assets/logo.png' ?>')">

    <main class="container-fluid d-grid" style="min-height: 100vh;place-items: center;">
        <div class="row w-100">
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

    <script>
        $(document).ready(function() {
            $('[type=password]').val('');
            $('[type=password]').css('color', '');
        });

        const passwordEyeBtn = $('.password-container .password-eye')
        const passwordEyeOffBtn = $('.password-container .password-eye-off')
        const password = $('.password-container #password')

        passwordEyeBtn.on('click', function() {
            $(this).hide();
            passwordEyeOffBtn.show();
            password.attr('type', 'text');
        })

        passwordEyeOffBtn.on('click', function() {
            $(this).hide();
            passwordEyeBtn.show();
            password.attr('type', 'password');
        })
    </script>

</body>

</html>