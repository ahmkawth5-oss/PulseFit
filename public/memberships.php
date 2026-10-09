<?php

session_start();

require_once __DIR__ . "/../classes/membership.php";

$membershipModel = new Membership();

$memberships = $membershipModel->getAllMemberships();

require_once __DIR__ . "/../includes/header.php";

?>

<main class="public-page">

    <section class="page-hero">

        <h1>Membership Plans</h1>

        <p>
            Choose the membership plan that fits your fitness goals.
        </p>

    </section>


    <section class="membership-section">

        <?php if (!empty($memberships)): ?>

            <div class="membership-grid">

                <?php foreach ($memberships as $membership): ?>

                    <article class="membership-card">

                        <div class="membership-card-header">

                            <h2>
                                <?= htmlspecialchars(
                                    $membership["membership_name"]
                                ) ?>
                            </h2>

                        </div>


                        <div class="membership-price">

                            <span class="price">
                                $<?= htmlspecialchars(
                                    $membership["price"]
                                ) ?>
                            </span>

                            <span class="duration">
                                /
                                <?= htmlspecialchars(
                                    $membership["duration"]
                                ) ?>
                                month(s)
                            </span>

                        </div>


                        <div class="membership-description">

                            <p>
                                <?= htmlspecialchars(
                                    $membership["description"]
                                ) ?>
                            </p>

                        </div>


                        <div class="membership-action">

                            <?php if (isset($_SESSION["user_id"])): ?>

                                <a
                                    href="../pages/subscriptions/add_subscription.php?membership_id=<?= (int) $membership["membership_id"] ?>"
                                    class="form-button"
                                >
                                    Join Now
                                </a>

                            <?php else: ?>

                                <a
                                    href="../auth/signup.php"
                                    class="form-button"
                                >
                                    Join Now
                                </a>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty-state">

                <h2>No Membership Plans Available</h2>

                <p>
                    Membership plans are currently unavailable.
                    Please check again later.
                </p>

            </div>

        <?php endif; ?>

    </section>

</main>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>