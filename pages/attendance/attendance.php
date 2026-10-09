<?php

require_once __DIR__ . "/../../functions/helpers.php";

startSession();

requireLogin();

require_once __DIR__ . "/../../classes/attendance.php";

$attendance = new Attendance();

$profile_id = (int) $_SESSION["profile_id"];


// ==========================================
// User Type
// ==========================================

$isAdminOrManager =
    ($profile_id == 1 || $profile_id == 2);

$isMemberOrTrainer =
    ($profile_id == 3 || $profile_id == 4);


// ==========================================
// Get Attendance Records
// ==========================================

if ($isAdminOrManager) {

    // Admin / Manager can see all attendance

    $records = $attendance->getAllAttendance();

} elseif ($isMemberOrTrainer) {

    // Member / Trainer can see only his attendance

    $records = $attendance->getAttendanceByUserId(
        $_SESSION["user_id"]
    );

} else {

    redirect(loginUrl());

}


// ==========================================
// Get Attendance By ID
// ==========================================

$attendanceRecord = null;

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["attendance_id"])
) {

    $attendance_id = trim(
        $_POST["attendance_id"]
    );


    if (is_numeric($attendance_id)) {

        $attendance_id = (int) $attendance_id;


        if ($isAdminOrManager) {

            // Admin / Manager can view any record

            $attendanceRecord =
                $attendance->getById(
                    $attendance_id
                );

        } else {

            // Member / Trainer can view only his record

            $attendanceRecord =
                $attendance->fetchOne(
                    "SELECT
                        attendance.*,
                        users.full_name,
                        users.username,
                        users.role,
                        classes.class_name,
                        classes.class_date,
                        classes.start_time
                     FROM attendance
                     INNER JOIN users
                        ON attendance.user_id = users.user_id
                     LEFT JOIN classes
                        ON attendance.class_id = classes.class_id
                     WHERE attendance.attendance_id = ?
                     AND attendance.user_id = ?",
                    "ii",
                    $attendance_id,
                    $_SESSION["user_id"]
                );

        }

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

    <title>
        Attendance - PulseFit
    </title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>

<div class="main-content">


    <!-- Page Header -->

    <div class="dashboard-header">

        <h1>
            Attendance
        </h1>

        <p>
            Manage gym attendance
        </p>

    </div>


    <!-- Add Attendance -->

    <?php if ($isAdminOrManager || $isMemberOrTrainer): ?>

        <a href="add_attendance.php">
            Add Attendance
        </a>

    <?php endif; ?>


    <!-- Attendance Table -->

    <table>

        <tr>

            <th>ID</th>

            <th>User</th>

            <th>Role</th>

            <th>Class</th>

            <th>Check In</th>

            <th>Check Out</th>


            <?php if ($isAdminOrManager): ?>

                <th>Actions</th>

            <?php endif; ?>

        </tr>


        <?php foreach ($records as $item): ?>

            <tr>

                <td>
                    <?= htmlspecialchars(
                        $item["attendance_id"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $item["full_name"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $item["role"]
                    ) ?>
                </td>


                <td>

                    <?php if ($item["class_name"]): ?>

                        <?= htmlspecialchars(
                            $item["class_name"]
                        ) ?>

                    <?php else: ?>

                        No Class

                    <?php endif; ?>

                </td>


                <td>
                    <?= htmlspecialchars(
                        $item["check_in"]
                    ) ?>
                </td>


                <td>

                    <?php if ($item["check_out"]): ?>

                        <?= htmlspecialchars(
                            $item["check_out"]
                        ) ?>

                    <?php else: ?>

                        Still inside

                    <?php endif; ?>

                </td>


                <!-- Actions -->

                <?php if ($isAdminOrManager): ?>

                    <td>

                        <div class="table-actions">

                            <a
                                href="edit_attendance.php?id=<?= $item["attendance_id"] ?>"
                                class="edit-button"
                            >
                                Edit
                            </a>


                            <a
                                href="delete_attendance.php?id=<?= $item["attendance_id"] ?>"
                                class="delete-button"
                                onclick="return confirm('Are you sure you want to delete this attendance record?');"
                            >
                                Delete
                            </a>

                        </div>

                    </td>

                <?php endif; ?>

            </tr>

        <?php endforeach; ?>

    </table>


    <!-- Get Attendance By ID -->

    <div class="form-container">

        <h2>
            Get Attendance By ID
        </h2>


        <form method="POST">

            <div class="form-group">

                <label for="attendance_id">
                    Attendance ID
                </label>


                <input
                    type="number"
                    id="attendance_id"
                    name="attendance_id"
                    min="1"
                    required
                >

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Get Attendance
            </button>

        </form>

    </div>


    <!-- Selected Attendance -->

    <?php if (
        $_SERVER["REQUEST_METHOD"] === "POST" &&
        isset($_POST["attendance_id"])
    ): ?>

        <?php if ($attendanceRecord): ?>

            <div class="record-container">

                <h2>
                    Attendance Record
                </h2>


                <table>

                    <tr>

                        <th>ID</th>

                        <th>User</th>

                        <th>Role</th>

                        <th>Class</th>

                        <th>Check In</th>

                        <th>Check Out</th>

                    </tr>


                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $attendanceRecord["attendance_id"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $attendanceRecord["full_name"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $attendanceRecord["role"]
                            ) ?>
                        </td>


                        <td>

                            <?php if (
                                $attendanceRecord["class_name"]
                            ): ?>

                                <?= htmlspecialchars(
                                    $attendanceRecord["class_name"]
                                ) ?>

                            <?php else: ?>

                                No Class

                            <?php endif; ?>

                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $attendanceRecord["check_in"]
                            ) ?>
                        </td>


                        <td>

                            <?php if (
                                $attendanceRecord["check_out"]
                            ): ?>

                                <?= htmlspecialchars(
                                    $attendanceRecord["check_out"]
                                ) ?>

                            <?php else: ?>

                                Still inside

                            <?php endif; ?>

                        </td>

                    </tr>

                </table>

            </div>


        <?php else: ?>

            <div class="auth-message">

                Attendance record not found or you do not have permission to view it.

            </div>

        <?php endif; ?>

    <?php endif; ?>


</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>