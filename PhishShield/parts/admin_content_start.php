<?php
$host = 'http://' . $_SERVER['HTTP_HOST'] . '/phishshield';

if (!isset($head)) {
    die('Head is undefined');
}

session_start();

if (!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit;
}

include '../database.php';

$admin_id = $_SESSION['admin_id'];
$user_id = $_SESSION['user_id'];
$admin_username = $_SESSION['admin_username'];
$role_id = $_SESSION['role_id'];

// Display Name
$query = "SELECT display_name, profile FROM accounts WHERE id = :admin_id";
$stmt = $conn->prepare($query);

$stmt->bindParam(':admin_id', $admin_id);
$stmt->execute();
$account_data = $stmt->fetch(PDO::FETCH_ASSOC);
$display_name = $account_data['display_name'];
$profile = $account_data['profile'];

// Permission
$query = "SELECT permission.* FROM roles JOIN permission ON roles.id = permission.role_id WHERE roles.id = :role_id";
$stmt = $conn->prepare($query);

$stmt->bindParam(':role_id', $role_id);
$stmt->execute();
$permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$permission_modules = [];

foreach ($permissions as $key => $value) {
    $permission_modules[$value['module']][$value['action']] = $value['is_accessible'];
}

$permissions = $permission_modules;


if (isset($permissions[$head['route-name']])) {
    $page_permission = $permissions[$head['route-name']];
    $can_create = $page_permission['create'] == 1;
    $can_read = $page_permission['read'] == 1;
    $can_update = $page_permission['update'] == 1;
    $can_delete = $page_permission['delete'] == 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $head['title'] ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="<?php echo $host . '/style/admin/style.css' ?>" />

    <!-- Enqueue style -->
    <?php
    if (isset($head['style'])) {
        foreach ($head['style'] as $key => $value) {
    ?>
            <link rel="stylesheet" href='<?php echo $host . '/style' . $value ?>'>
    <?php
        }
    }
    ?>

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
        }

        body:before {
            content: '';
            position: fixed;
            inset: 0;
            background-color: rgba(255, 255, 255, 0.5);
            z-index: -1;
        }

        .access-denied {
            height: 100vh;
            width: 100vw;
            display: grid;
            place-items: center;
        }

        #content header {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

    <!-- Enqueue script -->
    <?php
    if (isset($head['script'])) {
        foreach ($head['script'] as $key => $value) {
    ?>
            <script defer src="<?php echo $host . '/script' . $value ?>"></script>
    <?php
        }
    }
    ?>
</head>

<body style="background-image: url('<?php echo $host . '/assets/logo.png' ?>')">
    <?php
    if (isset($can_read) && !$can_read) {
    ?>
        <div class="access-denied">
            <div class="text-center">
                <h3 class="text-danger mb-4">Access denied.</h3>
                <a href="<?php echo $host . '/admin/dashboard.php' ?>" class="btn btn-primary">
                    Go to Dashboard
                </a>
            </div>
        </div>
    <?php
        exit;
    }
    ?>


    <div class="container-fluid">
        <div class="row">
            <?php include 'navigation.php'; ?>
            <div id="content" class="col-10 min-vh-100 d-flex flex-column">
                <?php include 'admin_header.php'; ?>
                <main class="p-3 flex-grow-1">