<?php

require_once __DIR__ . "/../../functions/helpers.php";

startSession();

requirePermission("manage_bookings");

$profile_id = (int) $_SESSION["profile_id"];


// ==========================================
// Trainer Cannot Edit
// ==========================================

if ($profile_id == 3) {

    redirect(loginUrl());
}


// ==========================================
// Include Classes
// ==========================================

require_once __DIR__ . "/../../classes/booking.php";
require_once __DIR__ . "/../../classes/member.php";
require_once __DIR__ . "/../../classes/gym_class.php";

$booking = new Booking();
$member = new Member();
$class = new ClassModel();


// ==========================================
// Check Booking ID
// ==========================================

if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {

    redirect("bookings.php");
}

$booking_id = (int) $_GET["id"];


// ==========================================
// Get Booking
// ==========================================

$data = $booking->getBookingById($booking_id);

if (!$data) {

    redirect("bookings.php");
}


// ==========================================
// Member Ownership
// ==========================================

$currentMember = null;

if ($profile_id == 4) {

    $currentMember = $member->getByUserId(
        $_SESSION["user_id"]
    );

    if (!$currentMember) {

        redirect(loginUrl());
    }


    // Member can edit only own booking

    if (
        (int) $data["member_id"] !==
        (int) $currentMember["member_id"]
    ) {

        redirect(loginUrl());
    }
}


// ==========================================
// Get Members And Classes
// ==========================================

if ($profile_id == 1 || $profile_id == 2) {

    $members = $member->getAll();

} else {

    $members = [$currentMember];
}

$classes = $class->getAllClasses();

$message = "";


// ==========================================
// Update Booking
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $booking_date = trim(
        $_POST["booking_date"] ?? ""
    );

    $status = trim(
        $_POST["status"] ?? ""
    );

    $member_id = trim(
        $_POST["member_id"] ?? ""
    );

    $class_id = trim(
        $_POST["class_id"] ?? ""
    );


    // ==========================================
    // Member Security
    // ==========================================

    if ($profile_id == 4) {

        // Member cannot change booking owner

        $member_id = $currentMember["member_id"];
    }


    // ==========================================
    // Validate Fields
    // ==========================================

    if (
        $booking_date === "" ||
        $status === "" ||
        $member_id === "" ||
        $class_id === ""
    ) {

        $message =
            "Please fill in all required fields.";

    } else {

        $result = $booking->updateBooking(
            $booking_id,
            $booking_date,
            $status,
            $member_id,
            $class_id
        );


        if ($result !== false) {

            redirect("bookings.php");
        }


        $message =
            "Failed to update booking. " .
            "The member may already be booked for this class " .
            "or the class may be full.";
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

    <title>Edit Booking - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>

<body>

<div class="main-content">

    <div class="dashboard-header">

        <h1>
            Edit Booking
        </h1>

        <p>
            Update class booking
        </p>

    </div>


    <?php if ($message !== ""): ?>

        <div class="auth-message">

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>


    <div class="form-container">

        <form method="POST">


            <div class="form-group">

                <label for="member_id">
                    Member
                </label>


                <?php if ($profile_id == 4): ?>

                    <input
                        type="text"
                        value="<?= htmlspecialchars(
                            $currentMember["full_name"]
                        ) ?>"
                        disabled
                    >

                    <input
                        type="hidden"
                        name="member_id"
                        value="<?= $currentMember["member_id"] ?>"
                    >

                <?php else: ?>

                    <select
                        id="member_id"
                        name="member_id"
                        required
                    >

                        <?php foreach ($members as $item): ?>

                            <option
                                value="<?= $item["member_id"] ?>"
                                <?= (
                                    (
                                        $_POST["member_id"]
                                        ?? $data["member_id"]
                                    )
                                    == $item["member_id"]
                                ) ? "selected" : "" ?>
                            >

                                <?= htmlspecialchars(
                                    $item["full_name"]
                                ) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                <?php endif; ?>

            </div>


            <div class="form-group">

                <label for="class_id">
                    Class
                </label>

                <select
                    id="class_id"
                    name="class_id"
                    required
                >

                    <?php foreach ($classes as $item): ?>

                        <option
                            value="<?= $item["class_id"] ?>"
                            <?= (
                                (
                                    $_POST["class_id"]
                                    ?? $data["class_id"]
                                )
                                == $item["class_id"]
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


            <div class="form-group">

                <label for="booking_date">
                    Booking Date
                </label>

                <input
                    type="date"
                    id="booking_date"
                    name="booking_date"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["booking_date"]
                        ?? $data["booking_date"]
                    ) ?>"
                >

            </div>


            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    required
                >

                    <option
                        value="Confirmed"
                        <?= (
                            (
                                $_POST["status"]
                                ?? $data["status"]
                            )
                            === "Confirmed"
                        ) ? "selected" : "" ?>
                    >
                        Confirmed
                    </option>

                    <option
                        value="Pending"
                        <?= (
                            (
                                $_POST["status"]
                                ?? $data["status"]
                            )
                            === "Pending"
                        ) ? "selected" : "" ?>
                    >
                        Pending
                    </option>

                    <option
                        value="Cancelled"
                        <?= (
                            (
                                $_POST["status"]
                                ?? $data["status"]
                            )
                            === "Cancelled"
                        ) ? "selected" : "" ?>
                    >
                        Cancelled
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Update Booking
            </button>


            <div>

                <a
                    href="bookings.php"
                    class="back-link"
                >
                    Back to Bookings
                </a>

            </div>

        </form>

    </div>

</div>

<script src="../../assets/js/theme.js"></script>

</body>

</html>