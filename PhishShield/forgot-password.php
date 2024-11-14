<?php

$head = [
    'title' => 'Password Reset',
    'route-name' => 'forgot-password',
    'style' => ['/user.css'],
    'script' => [],
];

require './database.php';
require './parts/content_start.php';
require './helpers/smtp.php';
require './helpers/index.php';


if (isset($_SESSION['ps_user_id']) && isset($_SESSION['ps_username'])) {
    header("Location: home.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    try {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user) {
            $temporary_password = generateRandomString();
            $hashed_password = password_hash($temporary_password, PASSWORD_DEFAULT);

            $query = "UPDATE accounts SET password = :password WHERE user_id = :user_id";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':user_id', $user['id']);
            
            $stmt->execute();

            $success_message = sendEmailWithSMTP($email, "Phishshield Password Reset", "Temporary password: $temporary_password");
        } else {
            $error_message = "Email address does not exist.";
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
                        <form id="forgotPasswordForm" class="my-4" method="post" accept="#" autocomplete="off">
                            <?php if (!empty($success_message)) { ?>
                                <div class="success mx-auto mb-3 py-2 px-3"><?php echo $success_message; ?></div>
                            <?php } elseif (!empty($error_message)) { ?>
                                <div class="error mx-auto mb-3 py-2 px-3"><?php echo $error_message; ?></div>
                            <?php } ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Enter Email Address</label>
                                <input type="email" class="form-control radius-0 border-3 border-white bg-transparent" id="email" name="email" placeholder="email@example.com" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="primary-button">SUBMIT</button>
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
