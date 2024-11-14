<?php
$routes = [
    'Home' => [
        'url' => $host . '/home.php',
        'route-names' => ['home'],
    ],
    'Profile' => [
        'url' => $host . '/profile.php',
        'route-names' => ['profile', 'edit-profile'],
    ],
    'Report List' => [
        'url' => $host . '/report-list.php',
        'route-names' => ['report-list'],
    ],
];

?>

<div id="sidebar" class="col-2 min-vh-100 d-flex flex-column flex-shrink-0 py-3 px-0">
    <a href="<?php echo $host . '/home.php' ?>" class="d-flex align-items-center mb-md-0 mx-md-auto text-decoration-none">
        <img height="100" width="114" class="logo" src="<?php echo $host . '/assets/logo.png' ?>" alt="Logo">
    </a>
    <ul class="mt-4 nav nav-pills flex-column mb-auto">
        <?php
        foreach ($routes as $key => $value) {
        ?>
            <li>
                <a href="<?php echo $value['url']; ?>" class="navigation-button <?php echo in_array($head['route-name'], $value['route-names']) ? 'active' : '' ?>">
                    <?php echo $key; ?>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>
</div>