<header aria-label="Page Header" class="flex-shrink-0 p-3">
    <h1><?php echo $head['title'] ?></h1>
    <div class="user">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none link-dark dropdown-toggle"
                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $host . '/uploads/' . ($account_info['profile'] ?: 'user.png') ?>" alt="" width="40" height="40" class="rounded-circle me-2 object-fit-cover">
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="<?php echo $host . '/profile.php' ?>">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?php echo $host . '/sign-out.php' ?>">Sign out</a></li>
            </ul>
        </div>
    </div>
</header>