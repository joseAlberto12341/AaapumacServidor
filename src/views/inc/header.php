<!DOCTYPE html>
<html lang="en">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--====== Title ======-->
    <title> AAAPUMAC :: Asociación de Agentes Aduanales del Puerto de Manzanillo, A.C. || </title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="/Aaapumac/src/views/assets/img/favicon.ico" type="img/png" />

    <?php include (__DIR__ . '/styles.php'); ?>

</head>

<body <?php if ($answer['scripts'] == 'admin')
    echo 'class="with-welcome-text"' ?? null; ?>>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> 
        browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> 
        to improve your experience and security.</p>
    <![endif]-->

    <!--====== Preloader ======-->
    <div id="preloader">
        <div class="loader-cubes">
            <div class="loader-cube1 loader-cube"></div>
            <div class="loader-cube2 loader-cube"></div>
            <div class="loader-cube4 loader-cube"></div>
            <div class="loader-cube3 loader-cube"></div>
        </div>
    </div>

    <main>
        <header class="header-three sticky-header">
            <!-- Header Menu  -->
            <?php if ($answer['scripts'] == 'prime')
                include (__DIR__ . '/nav.php') ?? null; ?>
        </header>