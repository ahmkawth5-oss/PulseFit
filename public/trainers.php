<?php

session_start();

require_once __DIR__ . "/../classes/trainer.php";

$trainerModel = new Trainer();

$trainers = $trainerModel->getActiveTrainers();

require_once __DIR__ . "/../includes/header.php";

?>

<main class="public-page trainers-page">

    <section class="page-hero">

        <h1>Meet Our Trainers</h1>

        <p>
            Train with experienced professionals who are ready
            to help you reach your fitness goals.
        </p>

    </section>


    <section class="trainers-section">

        <?php if (!empty($trainers)): ?>

            <div class="trainers-grid">

                <?php foreach ($trainers as $trainer): ?>

                    <?php
                    $fullName = $trainer["full_name"];
                    $initials = "";

                    $nameParts = preg_split(
                        '/\s+/',
                        trim($fullName)
                    );

                    if (!empty($nameParts[0])) {
                        $initials .= strtoupper(
                            substr($nameParts[0], 0, 1)
                        );
                    }

                    if (
                        count($nameParts) > 1 &&
                        !empty($nameParts[count($nameParts) - 1])
                    ) {
                        $initials .= strtoupper(
                            substr(
                                $nameParts[count($nameParts) - 1],
                                0,
                                1
                            )
                        );
                    }

                    $imagePath = "";

                    if (!empty($trainer["image"])) {
                        $imagePath =
                            "/PulseFit/uploads/trainers/" .
                            $trainer["image"];
                    }
                    ?>


                    <article class="trainer-card">

                        <div class="trainer-image">

                            <?php if ($imagePath !== ""): ?>

                                <img
                                    src="<?= htmlspecialchars($imagePath) ?>"
                                    alt="<?= htmlspecialchars(
                                        $fullName
                                    ) ?>"
                                >

                            <?php else: ?>

                                <div class="trainer-placeholder">
                                    <?= htmlspecialchars($initials) ?>
                                </div>

                            <?php endif; ?>

                        </div>


                        <div class="trainer-info">

                            <h2>
                                <?= htmlspecialchars($fullName) ?>
                            </h2>


                            <p class="trainer-specialty">
                                <?= htmlspecialchars(
                                    $trainer["specialty"]
                                ) ?>
                            </p>


                            <div class="trainer-details">

                                <div class="trainer-detail">

                                    <span class="detail-label">
                                        Experience
                                    </span>

                                    <span class="detail-value">
                                        Professional Trainer
                                    </span>

                                </div>


                                <div class="trainer-detail">

                                    <span class="detail-label">
                                        Status
                                    </span>

                                    <span class="trainer-status">
                                        Active
                                    </span>

                                </div>

                            </div>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty-state">

                <h2>No Trainers Available</h2>

                <p>
                    Our trainer profiles are currently unavailable.
                    Please check again later.
                </p>

            </div>

        <?php endif; ?>

    </section>

</main>


<?php require_once __DIR__ . "/../includes/footer.php"; ?>