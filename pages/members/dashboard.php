<?php

require_once __DIR__ . "/../../functions/helpers.php";
requireProfile(4);

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../classes/member.php";


if (!isset($_SESSION["user_id"])) {

    header("Location: ../../auth/login.php");
    exit;

}


if ($_SESSION["profile_id"] != 4) {

    header("Location: ../../auth/login.php");
    exit;

}


$memberModel = new Member();

$user_id = $_SESSION["user_id"];


$member = $memberModel->getByUserId($user_id);


if (!$member) {

    die("Member information not found.");

}


$member_id = $member["member_id"];


$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM attendance
     WHERE user_id = $user_id"
);

$attendanceCount = $result->fetch_assoc()["total"];


$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM bookings
     WHERE member_id = $member_id"
);

$bookingCount = $result->fetch_assoc()["total"];


$stmt = $conn->prepare(
    "SELECT
        subscriptions.*,
        memberships.membership_name
     FROM subscriptions
     INNER JOIN memberships
        ON subscriptions.membership_id = memberships.membership_id
     WHERE subscriptions.member_id = ?
     AND subscriptions.status = 'Active'
     LIMIT 1"
);

$stmt->bind_param(
    "i",
    $member_id
);

$stmt->execute();

$subscription = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Member Dashboard - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>

<div class="dashboard">


    <!-- =========================
         Sidebar
    ========================= -->

    <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>


    <!-- =========================
         Main Content
    ========================= -->

    <main class="main-content">


        <header class="dashboard-header">

            <div>

                <h1>
                    Member Dashboard
                </h1>

                <p>
                    Welcome to PulseFit,
                    <?= htmlspecialchars($member["full_name"]) ?>
                </p>

            </div>

        </header>


        <!-- =========================
             Statistics Cards
        ========================= -->

        <section class="cards">


            <div class="card">

                <h3>
                    My Attendance
                </h3>

                <p>
                    <?= $attendanceCount ?>
                </p>

                <a href="../attendance/attendance.php">
                    View
                </a>

            </div>


            <div class="card">

                <h3>
                    My Bookings
                </h3>

                <p>
                    <?= $bookingCount ?>
                </p>

                <a href="../bookings/bookings.php">
                    View
                </a>

            </div>


            <div class="card">

                <h3>
                    Subscription
                </h3>

                <?php if ($subscription): ?>

                    <p>
                        <?= htmlspecialchars(
                            $subscription["membership_name"]
                        ) ?>
                    </p>

                    <p>
                        <?= htmlspecialchars(
                            $subscription["status"]
                        ) ?>
                    </p>

                    <a href="../subscriptions/subscriptions.php">
                        View
                    </a>

                <?php else: ?>

                    <h4>
                        No active subscription
                    </h4>

                <?php endif; ?>

            </div>


        </section>


        <!-- =========================
             Member Profile
        ========================= -->

        <section class="profile-card">


            <div class="profile-header">


                <div class="profile-avatar">

                    <?php if (!empty($member["image"])): ?>

                        <img
                            src="/PulseFit/uploads/users/<?= htmlspecialchars($member["image"]) ?>"
                            alt="Profile Photo"
                        >

                    <?php else: ?>

                        <?= strtoupper(
                            substr($member["full_name"], 0, 1)
                        ) ?>

                    <?php endif; ?>

                </div>


                <div>

                    <h2>
                        <?= htmlspecialchars($member["full_name"]) ?>
                    </h2>

                    <p>
                        Member Profile
                    </p>

                </div>


            </div>


            <div class="profile-info">


                <div class="profile-item">

                    <span>
                        Username
                    </span>

                    <strong>
                        <?= htmlspecialchars($member["username"]) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Phone
                    </span>

                    <strong>
                        <?= htmlspecialchars($member["phone"]) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Email
                    </span>

                    <strong>
                        <?= htmlspecialchars($member["email"]) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Gender
                    </span>

                    <strong>
                        <?= htmlspecialchars($member["gender"]) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Birth Date
                    </span>

                    <strong>
                        <?= htmlspecialchars($member["birth_date"]) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Join Date
                    </span>

                    <strong>
                        <?= htmlspecialchars($member["join_date"]) ?>
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


    </main>

</div>


<style>

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    display: block;
}

</style>

</body>

</html>