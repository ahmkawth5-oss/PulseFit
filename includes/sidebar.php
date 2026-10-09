<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$profile_id = $_SESSION["profile_id"] ?? null;

?>

<aside class="sidebar">

    <h2>PulseFit</h2>

    <nav>

        <!-- =========================
             Super Admin Sidebar
        ========================= -->

        <?php if ($profile_id == 1): ?>

            <a href="<?= baseUrl() ?>/index.php">
               🏠 Home
            </a>

            <a href="/PulseFit/pages/admin/super_admin/dashboard.php">
                Dashboard
            </a>

            <a href="/PulseFit/pages/admin/super_admin/users/users.php">
                Users
            </a>

            <a href="/PulseFit/pages/admin/managers/managers.php">
                Managers
            </a>

            <a href="/PulseFit/pages/trainers/trainers.php">
                Trainers
            </a>

            <a href="/PulseFit/pages/members/members.php">
                Members
            </a>

            <a href="/PulseFit/pages/memberships/memberships.php">
                Memberships
            </a>

            <a href="/PulseFit/pages/subscriptions/subscriptions.php">
                Subscriptions
            </a>

            <a href="/PulseFit/pages/payments/payments.php">
                Payments
            </a>

            <a href="/PulseFit/pages/gym_classes/classes.php">
                Classes
            </a>

            <a href="/PulseFit/pages/bookings/bookings.php">
                Bookings
            </a>

            <a href="/PulseFit/pages/attendance/attendance.php">
                Attendance
            </a>


        <!-- =========================
             Manager Sidebar
        ========================= -->

        <?php elseif ($profile_id == 2): ?>

            <a href="<?= baseUrl() ?>/index.php">
               🏠 Home
            </a>

            <a href="/PulseFit/pages/admin/managers/dashboard.php">
                Dashboard
            </a>

            <a href="/PulseFit/pages/trainers/trainers.php">
                Trainers
            </a>

            <a href="/PulseFit/pages/members/members.php">
                Members
            </a>

            <a href="/PulseFit/pages/memberships/memberships.php">
                Memberships
            </a>

            <a href="/PulseFit/pages/subscriptions/subscriptions.php">
                Subscriptions
            </a>

            <a href="/PulseFit/pages/payments/payments.php">
                Payments
            </a>

            <a href="/PulseFit/pages/gym_classes/classes.php">
                Classes
            </a>

            <a href="/PulseFit/pages/bookings/bookings.php">
                Bookings
            </a>

            <a href="/PulseFit/pages/attendance/attendance.php">
                Attendance
            </a>


        <!-- =========================
             Trainer Sidebar
        ========================= -->

        <?php elseif ($profile_id == 3): ?>

            

            <a href="<?= baseUrl() ?>/index.php">
               🏠 Home
            </a>

            <a href="/PulseFit/pages/trainers/dashboard.php">
                Dashboard
            </a>

            <a href="/PulseFit/pages/gym_classes/classes.php">
                Classes
            </a>

            <a href="/PulseFit/pages/bookings/bookings.php">
                Bookings
            </a>

            <a href="/PulseFit/pages/attendance/attendance.php">
                Attendance
            </a>


        <!-- =========================
             Member Sidebar
        ========================= -->

        <?php elseif ($profile_id == 4): ?>

            

            <a href="<?= baseUrl() ?>/index.php">
               🏠 Home
            </a>

            <a href="/PulseFit/pages/members/dashboard.php">
                Dashboard
            </a>

            <a href="/PulseFit/pages/subscriptions/subscriptions.php">
                Subscriptions
            </a>

            <a href="/PulseFit/pages/bookings/bookings.php">
                Bookings
            </a>

            <a href="/PulseFit/pages/attendance/attendance.php">
                Attendance
            </a>

        <?php endif; ?>

    </nav>


    <!-- =========================
         Sidebar Bottom
    ========================= -->
<div class="sidebar-bottom">

<a
    href="/PulseFit/auth/logout.php"
    class="logout-btn"
>
    Logout
</a>

</div>

</aside>