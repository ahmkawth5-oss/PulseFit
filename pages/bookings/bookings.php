<?php

require_once __DIR__ . "/../../functions/helpers.php";

startSession();

requirePermission("manage_bookings");

require_once __DIR__ . "/../../classes/booking.php";
require_once __DIR__ . "/../../classes/member.php";
require_once __DIR__ . "/../../classes/trainer.php";

$booking = new Booking();

$profile_id = (int) $_SESSION["profile_id"];


// ==========================================
// User Types
// ==========================================

$isAdminOrManager =
    ($profile_id == 1 || $profile_id == 2);

$isMember =
    ($profile_id == 4);

$isTrainer =
    ($profile_id == 3);


// ==========================================
// Get Bookings
// ==========================================

if ($isAdminOrManager) {

    // Admin / Manager
    // Can see all bookings

    $bookings = $booking->getAllBookings();


} elseif ($isMember) {

    // Member
    // Can see only own bookings

    $memberModel = new Member();

    $member = $memberModel->getByUserId(
        $_SESSION["user_id"]
    );

    if (!$member) {

        die("Member profile not found.");
    }

    $bookings = $booking->getBookingsByMemberId(
        $member["member_id"]
    );


} elseif ($isTrainer) {

    // Trainer
    // Can see bookings belonging
    // to his classes

    $trainerModel = new Trainer();

    $trainer = $trainerModel->getTrainerByUserId(
        $_SESSION["user_id"]
    );

    if (!$trainer) {

        die("Trainer profile not found.");
    }

    $bookings = $booking->getBookingsByTrainerId(
        $trainer["trainer_id"]
    );


} else {

    redirect(loginUrl());
}


// ==========================================
// View Booking By ID
// ==========================================

$bookingRecord = null;

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["booking_id"])
) {

    $booking_id = trim(
        $_POST["booking_id"]
    );


    if (is_numeric($booking_id)) {

        $booking_id = (int) $booking_id;


        // ==================================
        // Admin / Manager
        // Can view any booking
        // ==================================

        if ($isAdminOrManager) {

            $bookingRecord =
                $booking->getById(
                    $booking_id
                );
        }


        // ==================================
        // Member
        // Can view only own booking
        // ==================================

        elseif ($isMember) {

            $bookingRecord =
                $booking->getBookingByIdForMember(
                    $booking_id,
                    $member["member_id"]
                );
        }


        // ==================================
        // Trainer
        // Can view only bookings
        // from his classes
        // ==================================

        elseif ($isTrainer) {

            $bookingRecord =
                $booking->getBookingByIdForTrainer(
                    $booking_id,
                    $trainer["trainer_id"]
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
        Bookings - PulseFit
    </title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>

<body>

<div class="main-content">


    <!-- =========================
         Page Header
    ========================= -->

    <div class="dashboard-header">

        <h1>
            Bookings
        </h1>

        <p>
            Manage class bookings
        </p>

    </div>


    <!-- =========================
         Add Booking
         Admin / Manager / Member
    ========================= -->

    <?php if (
        $isAdminOrManager ||
        $isMember
    ): ?>

        <a href="add_booking.php">
            Add Booking
        </a>

    <?php endif; ?>


    <!-- =========================
         Bookings Table
    ========================= -->

    <table>

        <tr>

            <th>ID</th>

            <th>Member</th>

            <th>Class</th>

            <th>Class Date</th>

            <th>Booking Date</th>

            <th>Status</th>


            <?php if (
                $isAdminOrManager ||
                $isMember
            ): ?>

                <th>Actions</th>

            <?php endif; ?>

        </tr>


        <?php foreach ($bookings as $item): ?>

            <tr>

                <td>
                    <?= htmlspecialchars(
                        $item["booking_id"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $item["full_name"]
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
                        $item["booking_date"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $item["status"]
                    ) ?>
                </td>


                <!-- =====================
                     Actions
                ====================== -->

                <?php if (
                    $isAdminOrManager ||
                    $isMember
                ): ?>

                    <td>

                        <div class="table-actions">


                            <!-- Edit -->
                            <a
                                href="edit_booking.php?id=<?= $item["booking_id"] ?>"
                                class="edit-button"
                            >
                                Edit
                            </a>


                            <!-- Delete -->
                            <?php if ($isAdminOrManager): ?>

                                <a
                                    href="delete_booking.php?id=<?= $item["booking_id"] ?>"
                                    class="delete-button"
                                    onclick="return confirm('Are you sure you want to delete this booking?');"
                                >
                                    Delete
                                </a>

                            <?php endif; ?>


                        </div>

                    </td>

                <?php endif; ?>

            </tr>

        <?php endforeach; ?>

    </table>


    <!-- =========================
         Get Booking By ID
    ========================= -->

    <div class="form-container">

        <h2>
            Get Booking By ID
        </h2>


        <form method="POST">

            <div class="form-group">

                <label for="booking_id">
                    Booking ID
                </label>

                <input
                    type="number"
                    id="booking_id"
                    name="booking_id"
                    min="1"
                    required
                >

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Get Booking
            </button>

        </form>

    </div>


    <!-- =========================
         Selected Booking
    ========================= -->

    <?php if ($bookingRecord): ?>

        <div class="record-container">

            <h2>
                Booking Record
            </h2>


            <table>

                <tr>

                    <th>ID</th>

                    <th>Booking Date</th>

                    <th>Status</th>

                    <th>Member ID</th>

                    <th>Class ID</th>

                </tr>


                <tr>

                    <td>
                        <?= htmlspecialchars(
                            $bookingRecord["booking_id"]
                        ) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $bookingRecord["booking_date"]
                        ) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $bookingRecord["status"]
                        ) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $bookingRecord["member_id"]
                        ) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $bookingRecord["class_id"]
                        ) ?>
                    </td>

                </tr>

            </table>

        </div>


    <?php elseif (
        $_SERVER["REQUEST_METHOD"] === "POST" &&
        isset($_POST["booking_id"])
    ): ?>


        <div class="auth-message">

            Booking not found or you do not have permission to view it.

        </div>

    <?php endif; ?>


</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>