<?php

require_once __DIR__ . "/../../functions/helpers.php";
requireProfile(3);

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../classes/trainer.php";

$trainerModel = new Trainer();

$user_id = $_SESSION["user_id"];


$stmt = $conn->prepare(
    "SELECT
        trainers.trainer_id,
        trainers.specialty,
        trainers.hire_date,
        trainers.salary,
        trainers.birth_date,
        users.full_name,
        users.username,
        users.email,
        users.phone,
        users.status,
        users.image
     FROM trainers
     INNER JOIN users
        ON trainers.user_id = users.user_id
     WHERE trainers.user_id = ?"
);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$result = $stmt->get_result();

$trainer = $result->fetch_assoc();

$stmt->close();


if (!$trainer) {

    die("Trainer profile not found.");

}


$trainer_id = $trainer["trainer_id"];


$stmt = $conn->prepare(
    "SELECT COUNT(*) AS total
     FROM classes
     WHERE trainer_id = ?"
);

$stmt->bind_param(
    "i",
    $trainer_id
);

$stmt->execute();

$myClasses = $stmt
    ->get_result()
    ->fetch_assoc()["total"];

$stmt->close();


$stmt = $conn->prepare(
    "SELECT COUNT(*) AS total
     FROM bookings
     INNER JOIN classes
        ON bookings.class_id = classes.class_id
     WHERE classes.trainer_id = ?"
);

$stmt->bind_param(
    "i",
    $trainer_id
);

$stmt->execute();

$myBookings = $stmt
    ->get_result()
    ->fetch_assoc()["total"];

$stmt->close();


$stmt = $conn->prepare(
    "SELECT COUNT(*) AS total
     FROM attendance
     INNER JOIN classes
        ON attendance.class_id = classes.class_id
     WHERE classes.trainer_id = ?"
);

$stmt->bind_param(
    "i",
    $trainer_id
);

$stmt->execute();

$myAttendance = $stmt
    ->get_result()
    ->fetch_assoc()["total"];

$stmt->close();


$stmt = $conn->prepare(
    "SELECT
        class_id,
        class_name,
        class_date,
        start_time,
        capacity
     FROM classes
     WHERE trainer_id = ?
     ORDER BY class_date ASC, start_time ASC
     LIMIT 5"
);

$stmt->bind_param(
    "i",
    $trainer_id
);

$stmt->execute();

$upcomingClasses = $stmt->get_result();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Trainer Dashboard - PulseFit
    </title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

    <style>

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

    </style>

</head>


<body>

<div class="dashboard">


    <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>


    <main class="main-content">


        <header class="dashboard-header">

            <div>

                <h1>
                    Trainer Dashboard
                </h1>

                <p>
                    Welcome to PulseFit,
                    <?= htmlspecialchars($trainer["full_name"]) ?>
                </p>

            </div>

        </header>


        <section class="cards">


            <div class="card">

                <h3>
                    My Classes
                </h3>

                <p>
                    <?= $myClasses ?>
                </p>

                <a href="/PulseFit/pages/gym_classes/classes.php">
                    Classes
                </a>

            </div>


            <div class="card">

                <h3>
                    My Bookings
                </h3>

                <p>
                    <?= $myBookings ?>
                </p>

                <a href="/PulseFit/pages/bookings/bookings.php">
                    Bookings
                </a>

            </div>


            <div class="card">

                <h3>
                    My Attendance
                </h3>

                <p>
                    <?= $myAttendance ?>
                </p>

                <a href="/PulseFit/pages/attendance/attendance.php">
                    Attendance
                </a>

            </div>


        </section>


        <section class="profile-card">


            <div class="profile-header">

                <div class="profile-avatar">

                    <?php if (!empty($trainer["image"])): ?>

                        <img
                            src="/PulseFit/uploads/users/<?= htmlspecialchars($trainer["image"]) ?>"
                            alt="Profile Photo"
                        >

                    <?php else: ?>

                        <?= strtoupper(
                            substr(
                                $trainer["full_name"],
                                0,
                                1
                            )
                        ) ?>

                    <?php endif; ?>

                </div>


                <div>

                    <h2>
                        <?= htmlspecialchars(
                            $trainer["full_name"]
                        ) ?>
                    </h2>

                    <p>
                        Trainer Profile
                    </p>

                </div>

            </div>


            <div class="profile-info">


                <div class="profile-item">

                    <span>
                        Username
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $trainer["username"]
                        ) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Specialty
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $trainer["specialty"]
                        ) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Phone
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $trainer["phone"]
                        ) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Email
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $trainer["email"]
                        ) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Birth Date
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $trainer["birth_date"]
                        ) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Hire Date
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $trainer["hire_date"]
                        ) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Status
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $trainer["status"]
                        ) ?>
                    </strong>

                </div>


                <div class="profile-item">

                    <span>
                        Salary
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $trainer["salary"]
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


        <section
            class="card"
            style="margin-top: 40px;"
        >

            <h2>
                My Upcoming Classes
            </h2>


            <?php if ($upcomingClasses->num_rows === 0): ?>

                <h3>
                    No classes found.
                </h3>


            <?php else: ?>

                <table>

                    <thead>

                        <tr>

                            <th>
                                ID
                            </th>

                            <th>
                                Class
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Start Time
                            </th>

                            <th>
                                Capacity
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php while (
                            $item = $upcomingClasses->fetch_assoc()
                        ): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars(
                                        $item["class_id"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $item["class_name"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $item["class_date"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $item["start_time"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $item["capacity"]
                                    ) ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            <?php endif; ?>

        </section>


    </main>

</div>

</body>

</html>