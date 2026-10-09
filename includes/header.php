<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PulseFit</title>
<link rel="stylesheet" href="/PulseFit/assets/css/style.css">

</head>
<body>

<header class="site-header">
    <div class="container header-content">

        <a href="/PulseFit/index.php" class="logo">
            <img src="/PulseFit/assets/images/logo.png" alt="PulseFit Logo">
        </a>


        <nav class="main-nav" id="mainNav">
            <a href="/PulseFit/index.php"
               class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">
                Home
            </a>

            <a href="/PulseFit/public/about.php"
               class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">
                About
            </a>

            <a href="/PulseFit/public/memberships.php"
               class="<?= $currentPage === 'memberships.php' ? 'active' : '' ?>">
                Memberships
            </a>

            <a href="/PulseFit/public/offers.php"
               class="<?= $currentPage === 'offers.php' ? 'active' : '' ?>">
                Offers
            </a>

            <a href="/PulseFit/public/trainers.php"
               class="<?= $currentPage === 'trainers.php' ? 'active' : '' ?>">
                Trainers
            </a>

            <a href="/PulseFit/public/classes.php"
               class="<?= $currentPage === 'classes.php' ? 'active' : '' ?>">
                Classes
            </a>

            <a href="/PulseFit/public/gallery.php"
               class="<?= $currentPage === 'gallery.php' ? 'active' : '' ?>">
                Gallery
            </a>

            <a href="/PulseFit/public/contact.php"
               class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>">
                Contact
            </a>
        </nav>

        <div class="header-actions">
            <a href="/PulseFit/auth/login.php" class="login-link">
                Login
            </a>

            <a href="/PulseFit/auth/signup.php" class="btn btn-primary">
                Join Now
            </a>

            <button class="menu-toggle" id="menuToggle" aria-label="Open navigation menu">
            ☰
            </button>

        </div>
    </div>
</header>
