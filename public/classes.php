<?php

session_start();

require_once __DIR__ . "/../classes/gym_class.php";
require_once __DIR__ . "/../classes/booking.php";

$classModel = new ClassModel();
$bookingModel = new Booking();

$classes = $classModel->getUpcomingClasses();

require_once __DIR__ . "/../includes/header.php";

?>

<main class="public-page classes-page">

    <section class="page-hero">

        <h1>Our Classes</h1>

        <p>
            Find a class that matches your goals and book your spot.
        </p>

    </section>


    <section class="classes-section">

        <?php if (!empty($classes)): ?>

            <div class="classes-grid">

                <?php foreach ($classes as $class): ?>

                    <?php
                    $booked = $bookingModel->getBookingCountByClassId(
                        $class["class_id"]
                    );

                    $capacity = (int) $class["capacity"];

                    $remaining = max(
                        0,
                        $capacity - $booked
                    );

                    if ($remaining <= 0) {
                        $availabilityClass = "class-full";
                        $availabilityText = "Full";
                    } elseif ($remaining <= 3) {
                        $availabilityClass = "class-almost-full";
                        $availabilityText = "Almost Full";
                    } else {
                        $availabilityClass = "class-available";
                        $availabilityText = "Available";
                    }
                    ?>


                    <article class="class-card">

                        <div class="class-card-top">

                            <span class="class-category">
                                Fitness Class
                            </span>

                            <span
                                class="class-status <?= $availabilityClass ?>"
                            >
                                <?= htmlspecialchars(
                                    $availabilityText
                                ) ?>
                            </span>

                        </div>


                        <div class="class-card-content">

                            <h2>
                                <?= htmlspecialchars(
                                    $class["class_name"]
                                ) ?>
                            </h2>


                            <div class="class-info">

                                <div class="class-info-item">

                                    <span class="class-info-label">
                                        Trainer
                                    </span>

                                    <span class="class-info-value">
                                        <?= htmlspecialchars(
                                            $class["full_name"]
                                        ) ?>
                                    </span>

                                </div>


                                <div class="class-info-item">

                                    <span class="class-info-label">
                                        Date
                                    </span>

                                    <span class="class-info-value">
                                        <?= htmlspecialchars(
                                            date(
                                                "M d, Y",
                                                strtotime(
                                                    $class["class_date"]
                                                )
                                            )
                                        ) ?>
                                    </span>

                                </div>


                                <div class="class-info-item">

                                    <span class="class-info-label">
                                        Time
                                    </span>

                                    <span class="class-info-value">
                                        <?= htmlspecialchars(
                                            $class["start_time"]
                                        ) ?>
                                    </span>

                                </div>

                            </div>


                            <div class="class-capacity">

                                <div class="capacity-header">

                                    <span>
                                        Availability
                                    </span>

                                    <strong>
                                        <?= $remaining ?>
                                        / <?= $capacity ?>
                                        spots
                                    </strong>

                                </div>


                                <div class="capacity-bar">

                                    <div
                                        class="capacity-progress <?= $availabilityClass ?>"
                                        style="width: <?= $capacity > 0
                                            ? min(
                                                100,
                                                ($booked / $capacity) * 100
                                            )
                                            : 0 ?>%;"
                                    ></div>

                                </div>


                                <p class="capacity-message">

                                    <?php if ($remaining <= 0): ?>

                                        This class is currently full.

                                    <?php elseif ($remaining <= 3): ?>

                                        Only <?= $remaining ?> spot(s) left.

                                    <?php else: ?>

                                        <?= $remaining ?> spots are available.

                                    <?php endif; ?>

                                </p>

                            </div>

                        </div>


                        <div class="class-card-action">

                            <?php if ($remaining > 0): ?>

                                <?php if (
                                    isset($_SESSION["user_id"]) &&
                                    isset($_SESSION["profile_id"]) &&
                                    $_SESSION["profile_id"] == 4
                                ): ?>

                                    <a
                                        href="../pages/bookings/add_booking.php?class_id=<?= (int) $class["class_id"] ?>"
                                        class="class-book-button"
                                    >
                                        Book Class
                                    </a>

                                <?php else: ?>

                                    <a
                                        href="../auth/login.php"
                                        class="class-book-button"
                                    >
                                        Login to Book
                                    </a>

                                <?php endif; ?>

                            <?php else: ?>

                                <span class="class-disabled-button">
                                    Class Full
                                </span>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty-state">

                <h2>No Upcoming Classes</h2>

                <p>
                    There are currently no upcoming classes.
                    Please check again later.
                </p>

            </div>

        <?php endif; ?>

    </section>

</main>


<?php require_once __DIR__ . "/../includes/footer.php"; ?>