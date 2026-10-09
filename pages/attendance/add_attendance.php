<?php

require_once __DIR__ . "/../../functions/helpers.php";

startSession();

requireLogin();

$profile_id = (int) $_SESSION["profile_id"];


// ==========================================
// Include Classes
// ==========================================

require_once __DIR__ . "/../../classes/attendance.php";
require_once __DIR__ . "/../../classes/user.php";
require_once __DIR__ . "/../../classes/gym_class.php";

$attendance = new Attendance();
$user = new User();
$class = new ClassModel();


// ==========================================
// Get Current User
// ==========================================

$currentUser = $user->getById($_SESSION["user_id"]);

if (!$currentUser) {
    redirect(loginUrl());
}


// ==========================================
// Get Users
// ==========================================

if ($profile_id == 1 || $profile_id == 2) {

    // Admin / Manager can select any user
    $users = $user->getAll();

} elseif ($profile_id == 3 || $profile_id == 4) {

    // Member / Trainer can add attendance only for himself
    $users = [$currentUser];

} else {

    redirect(loginUrl());
}


// ==========================================
// Get Classes
// ==========================================

$classes = $class->getAllClasses();

$message = "";


// ==========================================
// Add Attendance
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $check_in = trim($_POST["check_in"] ?? "");

    $check_out = !empty($_POST["check_out"])
        ? $_POST["check_out"]
        : null;

    $user_id = (int) ($_POST["user_id"] ?? 0);

    $class_id = !empty($_POST["class_id"])
        ? (int) $_POST["class_id"]
        : null;


    // ==========================================
    // Member / Trainer Security
    // ==========================================

    if ($profile_id == 3 || $profile_id == 4) {

        // Ignore submitted user_id
        // and force current user ID

        $user_id = (int) $_SESSION["user_id"];
    }


    // ==========================================
    // Validate Fields
    // ==========================================

    if (
        $check_in === "" ||
        $user_id <= 0
    ) {

        $message = "Please fill in all required fields.";

    } else {

        $result = $attendance->createAttendance(
            $check_in,
            $check_out,
            $user_id,
            $class_id
        );


        if ($result) {

            redirect("attendance.php");

        }


        $message = "Failed to add attendance. You may already have an open attendance record.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Attendance - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>

<div class="main-content">


    <div class="dashboard-header">

        <h1>
            Add Attendance
        </h1>

        <p>
            Record user attendance
        </p>

    </div>


    <?php if ($message !== ""): ?>

        <div class="auth-message">

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>


    <div class="form-container">

        <form method="POST">


            <!-- User -->

            <div class="form-group">

                <label for="user_id">
                    User
                </label>


                <?php if ($profile_id == 1 || $profile_id == 2): ?>

                    <select
                        id="user_id"
                        name="user_id"
                        required
                    >

                        <option value="">
                            Select User
                        </option>


                        <?php foreach ($users as $item): ?>

                            <?php
                            $role = strtolower($item["role"]);
                            ?>

                            <?php if (
                                $role === "member" ||
                                $role === "trainer"
                            ): ?>

                                <option
                                    value="<?= $item["user_id"] ?>"
                                    <?= (
                                        ($_POST["user_id"] ?? "") ==
                                        $item["user_id"]
                                    ) ? "selected" : "" ?>
                                >

                                    <?= htmlspecialchars(
                                        $item["full_name"]
                                    ) ?>

                                    -

                                    <?= htmlspecialchars(
                                        $item["role"]
                                    ) ?>

                                </option>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </select>


                <?php else: ?>

                    <input
                        type="text"
                        value="<?= htmlspecialchars(
                            $currentUser["full_name"]
                        ) ?>"
                        disabled
                    >


                    <input
                        type="hidden"
                        name="user_id"
                        value="<?= $currentUser["user_id"] ?>"
                    >

                <?php endif; ?>

            </div>


            <!-- Class -->

            <div class="form-group">

                <label for="class_id">
                    Class
                </label>


                <select
                    id="class_id"
                    name="class_id"
                >

                    <option value="">
                        No Class
                    </option>


                    <?php foreach ($classes as $item): ?>

                        <option
                            value="<?= $item["class_id"] ?>"
                            <?= (
                                ($_POST["class_id"] ?? "") ==
                                $item["class_id"]
                            ) ? "selected" : "" ?>
                        >

                            <?= htmlspecialchars(
                                $item["class_name"]
                                . " - "
                                . $item["class_date"]
                                . " - "
                                . $item["start_time"]
                            ) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- Check In -->

            <div class="form-group">

                <label for="check_in">
                    Check In
                </label>


                <input
                    type="datetime-local"
                    id="check_in"
                    name="check_in"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["check_in"] ?? ""
                    ) ?>"
                >

            </div>


            <!-- Check Out -->

            <div class="form-group">

                <label for="check_out">
                    Check Out
                </label>


                <input
                    type="datetime-local"
                    id="check_out"
                    name="check_out"
                    value="<?= htmlspecialchars(
                        $_POST["check_out"] ?? ""
                    ) ?>"
                >

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Add Attendance
            </button>


            <div>

                <a
                    href="attendance.php"
                    class="back-link"
                >
                    Back to Attendance
                </a>

            </div>


        </form>

    </div>


</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>