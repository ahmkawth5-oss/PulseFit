<?php

require_once __DIR__ . "/../../../functions/helpers.php";
requireLogin();

require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . "/../../../classes/trainer.php";

$trainer = new Trainer();


// =========================
// Current Admin Information
// =========================

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT
        user_id,
        full_name,
        username,
        phone,
        email,
        role,
        status,
        image
     FROM users
     WHERE user_id = ?"
);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

$stmt->close();


// =========================
// Statistics
// =========================


// Users

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM users"
);

$users = $result->fetch_assoc()["total"];


// Managers

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM users
     WHERE profile_id = 2"
);

$managers = $result->fetch_assoc()["total"];


// Members

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM members"
);

$members = $result->fetch_assoc()["total"];


// Trainers

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM trainers"
);

$trainers = $result->fetch_assoc()["total"];


// Memberships

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM memberships"
);

$memberships = $result->fetch_assoc()["total"];


// Subscriptions

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM subscriptions"
);

$subscriptions = $result->fetch_assoc()["total"];


// Payments

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM payments"
);

$payments = $result->fetch_assoc()["total"];


// Classes

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM classes"
);

$classes = $result->fetch_assoc()["total"];


// Bookings

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM bookings"
);

$bookings = $result->fetch_assoc()["total"];


// Attendance

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM attendance"
);

$attendance = $result->fetch_assoc()["total"];


// =========================
// Pending Trainer Approvals
// =========================

$pendingTrainers = $trainer->getPendingTrainers();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Super Admin Dashboard - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../../assets/css/style.css"
    >

</head>


<body>

<div class="dashboard">


    <!-- =========================
         Sidebar
    ========================= -->

    <?php require_once __DIR__ . "/../../../includes/sidebar.php"; ?>


    <!-- =========================
         Main Content
    ========================= -->

    <main class="main-content">


        <!-- =========================
             Dashboard Header
        ========================= -->

        <header class="dashboard-header">

            <div>

                <h1>
                    Super Admin Dashboard
                </h1>

                <p>
                    Welcome to PulseFit Management System
                </p>

            </div>

        </header>


        <!-- =========================
             Statistics Cards
        ========================= -->

        <section class="cards">


            <!-- Users -->

            <div class="card">

                <h3>
                    Users
                </h3>

                <p>
                    <?= $users ?>
                </p>

                <a href="users/users.php">
                    Manage
                </a>

            </div>


            <!-- Managers -->

            <div class="card">

                <h3>
                    Managers
                </h3>

                <p>
                    <?= $managers ?>
                </p>

                <a href="../managers/managers.php">
                    Manage
                </a>

            </div>


            <!-- Members -->

            <div class="card">

                <h3>
                    Members
                </h3>

                <p>
                    <?= $members ?>
                </p>

                <a href="../../members/members.php">
                    Manage
                </a>

            </div>


            <!-- Trainers -->

            <div class="card">

                <h3>
                    Trainers
                </h3>

                <p>
                    <?= $trainers ?>
                </p>

                <a href="../../trainers/trainers.php">
                    Manage
                </a>

            </div>


            <!-- Memberships -->

            <div class="card">

                <h3>
                    Memberships
                </h3>

                <p>
                    <?= $memberships ?>
                </p>

                <a href="../../memberships/memberships.php">
                    Manage
                </a>

            </div>


            <!-- Subscriptions -->

            <div class="card">

                <h3>
                    Subscriptions
                </h3>

                <p>
                    <?= $subscriptions ?>
                </p>

                <a href="../../subscriptions/subscriptions.php">
                    Manage
                </a>

            </div>


            <!-- Payments -->

            <div class="card">

                <h3>
                    Payments
                </h3>

                <p>
                    <?= $payments ?>
                </p>

                <a href="../../payments/payments.php">
                    Manage
                </a>

            </div>


            <!-- Classes -->

            <div class="card">

                <h3>
                    Classes
                </h3>

                <p>
                    <?= $classes ?>
                </p>

                <a href="../../gym_classes/classes.php">
                    Manage
                </a>

            </div>


            <!-- Bookings -->

            <div class="card">

                <h3>
                    Bookings
                </h3>

                <p>
                    <?= $bookings ?>
                </p>

                <a href="../../bookings/bookings.php">
                    Manage
                </a>

            </div>


            <!-- Attendance -->

            <div class="card">

                <h3>
                    Attendance
                </h3>

                <p>
                    <?= $attendance ?>
                </p>

                <a href="../../attendance/attendance.php">
                    Manage
                </a>

            </div>


        </section>


        <!-- =========================
             Admin Information
        ========================= -->

        <section class="profile-card">

            <div class="profile-header">


                <!-- Profile Image -->

                <div class="profile-avatar">

                    <?php if (!empty($user["image"])): ?>

                        <img
                            src="/PulseFit/uploads/users/<?= htmlspecialchars($user["image"]) ?>"
                            alt="Profile Photo"
                        >

                    <?php else: ?>

                        <?= strtoupper(
                            substr(
                                $user["full_name"],
                                0,
                                1
                            )
                        ) ?>

                    <?php endif; ?>

                </div>


                <!-- Admin Name -->

                <div>

                    <h2>
                        <?= htmlspecialchars(
                            $user["full_name"]
                        ) ?>
                    </h2>

                    <p>
                        Super Admin Profile
                    </p>

                </div>

            </div>


            <!-- Admin Information -->

            <div class="profile-info">


                <!-- Username -->

                <div class="profile-item">

                    <span>
                        Username
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $user["username"]
                        ) ?>
                    </strong>

                </div>


                <!-- Phone -->

                <div class="profile-item">

                    <span>
                        Phone
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $user["phone"]
                        ) ?>
                    </strong>

                </div>


                <!-- Email -->

                <div class="profile-item">

                    <span>
                        Email
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $user["email"]
                        ) ?>
                    </strong>

                </div>


                <!-- Role -->

                <div class="profile-item">

                    <span>
                        Role
                    </span>

                    <strong>
                        Super Admin
                    </strong>

                </div>


                <!-- Status -->

                <div class="profile-item">

                    <span>
                        Status
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $user["status"]
                        ) ?>
                    </strong>

                </div>


            </div>

            <div class="profile-card-actions">

    <a
        href="<?= baseUrl() ?>/pages/profile/edit.php"
        class="edit-profile-btn"
    >
        ✏️ Edit Profile
    </a>

</div>

        </section>


        <!-- =========================
             Pending Trainer Approvals
        ========================= -->

        <section
            class="card pending-approvals"
            style="margin-top: 70px;"
        >

            <h2>
                Pending Trainer Approvals
            </h2>


            <?php if (empty($pendingTrainers)): ?>

                <p>
                    No pending trainers.
                </p>


            <?php else: ?>


                <table>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Full Name
                        </th>

                        <th>
                            Username
                        </th>

                        <th>
                            Specialty
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>


                    <?php foreach ($pendingTrainers as $item): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars(
                                    $item["trainer_id"]
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $item["full_name"]
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $item["username"]
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $item["specialty"]
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $item["status"]
                                ) ?>
                            </td>



                            
                            <td>

                                <a
                                    href="approve_trainer.php?id=<?= $item["trainer_id"] ?>"
                                    class="edit-button"
                                >
                                    Approve
                                </a>

                            </td>

                        </tr>
                        

                    <?php endforeach; ?>


                </table>


            <?php endif; ?>



        </section>


    </main>

</div>


<script src="../../../assets/js/theme.js"></script>

</body>

</html>