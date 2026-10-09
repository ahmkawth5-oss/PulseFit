<?php

require_once __DIR__ . "/../../functions/helpers.php";

requireLogin();

$profile_id = (int) $_SESSION["profile_id"];


// ==========================================
// Add Booking Permission
// ==========================================

// Admin, Manager and Member can add bookings
if (
    $profile_id != 1 &&
    $profile_id != 2 &&
    $profile_id != 4
) {
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
// Get Members
// ==========================================

if ($profile_id == 1 || $profile_id == 2) {

    $members = $member->getAll();

} else {

    $currentMember = $member->getByUserId(
        $_SESSION["user_id"]
    );

    if (!$currentMember) {
        die("Member profile not found.");
    }

    $members = [$currentMember];
}


// ==========================================
// Get Classes
// ==========================================

$classes = $class->getAllClasses();

$message = "";


// ==========================================
// Add Booking
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

        $message = "Please fill in all required fields.";

    } else {

        $result = $booking->createBooking(
            $booking_date,
            $status,
            $member_id,
            $class_id
        );


        if ($result) {

            redirect("bookings.php");

        }


        $message =
            "Failed to add booking. " .
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

    <title>Add Booking - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>

<body>

<div class="main-content">

    <div class="dashboard-header">

        <h1>
            Add Booking
        </h1>

        <p>
            Create a new class booking
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


                <?php if ($profile_id == 1 || $profile_id == 2): ?>

                    <select
                        id="member_id"
                        name="member_id"
                        required
                    >

                        <option value="">
                            Select Member
                        </option>

                        <?php foreach ($members as $item): ?>

                            <option
                                value="<?= $item["member_id"] ?>"
                                <?= (
                                    ($_POST["member_id"] ?? "") ==
                                    $item["member_id"]
                                ) ? "selected" : "" ?>
                            >

                                <?= htmlspecialchars(
                                    $item["full_name"]
                                ) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                <?php else: ?>

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

                    <option value="">
                        Select Class
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
                        $_POST["booking_date"] ??
                        date("Y-m-d")
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

                    <option value="Confirmed">
                        Confirmed
                    </option>

                    <option value="Pending">
                        Pending
                    </option>

                    <option value="Cancelled">
                        Cancelled
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Add Booking
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