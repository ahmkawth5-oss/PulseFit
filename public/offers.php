<?php

session_start();

require_once __DIR__ . "/../classes/membership.php";
require_once __DIR__ . "/../classes/subscription.php";

$membershipModel = new Membership();
$subscriptionModel = new Subscription();

$memberships = $membershipModel->getAllMemberships();

$isLoggedIn = isset($_SESSION["user_id"]);
$userId = $isLoggedIn ? (int) $_SESSION["user_id"] : 0;

$hasSubscription = false;

if ($isLoggedIn) {

    $userSubscriptions = $subscriptionModel->getSubscriptionsByUserId(
        $userId
    );

    $hasSubscription = !empty($userSubscriptions);
}

require_once __DIR__ . "/../includes/header.php";
?>

<main class="public-page offers-page">

    <section class="page-hero">

        <h1>Special Offers</h1>

        <p>
            Save more and get the membership plan that fits your fitness goals.
        </p>

    </section>

    <section class="offers-section">

        <?php if (!empty($memberships)): ?>

            <div class="offers-grid">

                <?php foreach ($memberships as $membership): ?>

                    <?php

                    $membershipId = (int) $membership["membership_id"];
                    $price = (float) $membership["price"];
                    $duration = (int) $membership["duration"];

                    $offerType = "";
                    $offerTitle = "";
                    $discountPercent = 0;
                    $offerDescription = "";

                    /*
                     * New members get the highest available discount.
                     * Guests can also see this offer, but they must sign up first.
                     */
                    if (!$hasSubscription) {

                        $offerType = "new-member";
                        $offerTitle = "New Member Offer";
                        $discountPercent = 20;
                        $offerDescription =
                            "Get 20% off your first membership.";

                    } elseif ($duration >= 12) {

                        $offerType = "annual";
                        $offerTitle = "Annual Plan";
                        $discountPercent = 15;
                        $offerDescription =
                            "Save 15% when you choose a 12-month plan.";

                    } elseif ($duration >= 6) {

                        $offerType = "long-term";
                        $offerTitle = "Long-Term Plan";
                        $discountPercent = 10;
                        $offerDescription =
                            "Save 10% on memberships of 6 months or more.";

                    } else {

                        continue;
                    }

                    $discountAmount =
                        $price * ($discountPercent / 100);

                    $finalPrice =
                        $price - $discountAmount;

                    ?>

                    <article class="offer-card">

                        <div class="offer-badge">
                            <?= $discountPercent ?>% OFF
                        </div>

                        <div class="offer-card-content">

                            <span class="offer-label">
                                Special Offer
                            </span>

                            <h2>
                                <?= htmlspecialchars($offerTitle) ?>
                            </h2>

                            <h3>
                                <?= htmlspecialchars(
                                    $membership["membership_name"]
                                ) ?>
                            </h3>

                            <div class="offer-pricing">

                                <div class="offer-original-price">
                                    Original Price:
                                    <span>
                                        $<?= number_format($price, 2) ?>
                                    </span>
                                </div>

                                <div class="offer-discount">
                                    You Save:
                                    <strong>
                                        $<?= number_format(
                                            $discountAmount,
                                            2
                                        ) ?>
                                    </strong>
                                </div>

                                <div class="offer-final-price">

                                    <span>
                                        Final Price
                                    </span>

                                    <strong>
                                        $<?= number_format(
                                            $finalPrice,
                                            2
                                        ) ?>
                                    </strong>

                                </div>

                            </div>

                            <div class="offer-details">

                                <span>
                                    <?= $duration ?> month(s)
                                </span>

                            </div>

                            <p class="offer-description">
                                <?= htmlspecialchars(
                                    $offerDescription
                                ) ?>
                            </p>

                            <?php if ($isLoggedIn && !$hasSubscription): ?>

                                <a
                                    href="subscribe.php?membership_id=<?= $membershipId ?>&offer=new-member"
                                    class="offer-button"
                                >
                                    Claim 20% Offer
                                </a>

                            <?php elseif (!$isLoggedIn): ?>

                                <a
                                    href="../auth/signup.php"
                                    class="offer-button"
                                >
                                    Join & Claim Offer
                                </a>

                            <?php else: ?>

                                <a
                                    href="subscribe.php?membership_id=<?= $membershipId ?>&offer=<?= urlencode($offerType) ?>"
                                    class="offer-button"
                                >
                                    Get This Offer
                                </a>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty-state">

                <h2>No Offers Available</h2>

                <p>
                    There are currently no special offers available.
                    Please check again later.
                </p>

            </div>

        <?php endif; ?>

    </section>

</main>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>