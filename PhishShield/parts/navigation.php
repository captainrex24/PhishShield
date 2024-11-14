<?php
$routes = [
    'Dashboard' => [
        'url' => $host . '/admin/dashboard.php',
        'route-names' => ['dashboard'],
        'icon' => '<i class="bi bi-speedometer2 me-2"></i>',
    ],
    'Reports' => [
        'url' => $host . '/admin/reports.php',
        'route-names' => ['reports'],
        'icon' => '<i class="bi bi-list-ul me-2"></i>',
    ],
    'Allow List' => [
        'url' => $host . '/admin/allowlist.php',
        'route-names' => ['allowlist'],
        'icon' => '<i class="bi bi-database-check me-2"></i>',
    ],
    'Block List' => [
        'url' => $host . '/admin/blocklist.php',
        'route-names' => ['blocklist'],
        'icon' => '<i class="bi bi-database-x me-2"></i>',
    ],
    // 'Users' => [
    //     'url' => $host . '/admin/users.php',
    //     'route-names' => ['users'],
    //     'icon' => '<i class="bi bi-people me-2"></i>',
    // ],
    // 'Roles' => [
    //     'url' => $host . '/admin/roles.php',
    //     'route-names' => ['roles'],
    //     'icon' => '<i class="bi bi-person-fill-gear me-2"></i>',
    // ],
];

?>


<div id="sidebar" class="col-2 min-vh-100 d-flex flex-column flex-shrink-0 py-3 px-0 bg-primary-50">
    <a href="<?php echo $host . '/admin/dashboard.php' ?>" class="d-flex align-items-center mb-3 mb-md-0 mx-md-auto text-decoration-none">
        <img height="100" width="114" class="logo" src="<?php echo $host . '/assets/logo.png' ?>" alt="Logo">
    </a>
    <ul class="mt-4 nav nav-pills flex-column mb-auto">
        <?php
        foreach ($routes as $key => $value) {
            $routeName = $value['route-names'][0];

            if ($routeName != 'dashboard' && $permissions[$routeName]['read'] == 0) {
                continue;
            }
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