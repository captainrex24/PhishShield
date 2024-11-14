<?php
$host = 'http://' . $_SERVER['HTTP_HOST'] . '/phishshield';

if (!isset($head)) {
    die('Head is undefined');
}

session_start();

if (!isset($_SESSION['ps_user_id']) && !isset($_SESSION['ps_username'])) {
    header("Location: login.php");
    exit;
}

include './database.php';
include './user/get_profile.php';
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
    <div class="container-fluid">
        <div class="row">
            <?php include './parts/account_navigation.php'; ?>
            <div id="content" class="col-10 min-vh-100 d-flex flex-column">
                <?php include './parts/account_header.php'; ?>
                <main class="p-3 flex-grow-1">