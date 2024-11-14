<header class="flex-shrink-0 p-3 d-flex align-items-center bg-white">
    <a href="<?php echo $host . '/home.php'; ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
        <img height="70" width="80" class="logo" src="<?php echo $host . '/assets/logo.png' ?>" alt="Logo">
    </a>

    <nav>
        <div class="nav nav-pills align-items-center">
            <a href="<?php echo $host . '/home.php'; ?>" class="nav-link link-dark">
                Home
            </a>
            <?php
            if (!isset($_SESSION['ps_user_id'])) {
            ?>
                <a href="<?php echo $host . '/register.php'; ?>" class="nav-link link-dark">
                    Register
                </a>
                <a href="<?php echo $host . '/login.php'; ?>" class="primary-button">
                    Login
                </a>
            <?php
            } else {
            ?>
                <a href="<?php echo $host . '/profile.php'; ?>" class="nav-link link-dark">
                    Profile
                </a>
            <?php
            }
            ?>
        </div>
    </nav>
</header>