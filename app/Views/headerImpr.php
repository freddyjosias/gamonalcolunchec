<?php

    $user_session = session();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title . ' - ' . $nombreTienda ?></title>

    <link rel="shortcut icon" href="<?= base_url() . '/public/img/' . $logoTienda ?>" type="image/x-icon">

    <!-- Custom fonts for this template -->
    <link href="<?= base_url() ?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url() ?>/public/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= base_url() ?>/public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="<?= base_url() ?>/vendor/jquery/jquery.min.js"></script>
    <link href="<?= base_url() ?>/public/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css">
    
    <!--<script src="<?= base_url() ?>/js/jquery-3.5.1.min.js"></script>-->
    <script src="<?= base_url() ?>/public/js/jquery-ui/external/jquery/jquery.js"></script>
    <script src="<?= base_url() ?>/public/js/jquery-ui/jquery-ui.min.js"></script>

    <?php if (isset($css)) {
        foreach ($css as $key => $value) { ?>
            <link href="<?= base_url() ?>/public/css/<?= $value ?>.css" rel="stylesheet">
    <?php } 
    } 
    
    if (isset($anyChart)) { ?>
        <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
        <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
    <?php } ?>

</head>

<body id="page-top" onload="window.print()">