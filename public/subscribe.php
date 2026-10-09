<?php

session_start();

require_once __DIR__ . "/../classes/membership.php";
require_once __DIR__ . "/../classes/subscription.php";
require_once __DIR__ . "/../classes/member.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: ../auth/login.php");
    exit;
}

$userId = (int) $_SESSION["user_id"];

if (
    !isset($_SESSION["profile_id"]) ||
    (int) $_SESSION["profile_id"] !== 4
) {

    http_response_code(403);
    die("Only members can purchase memberships.");
}

$membershipId = isset($_GET["membership_id"])
    ? (int) $_GET["membership_id"]
    : 0;

$offerType = $_GET["offer"] ?? "";

$membershipModel = new Membership();
$subscriptionModel = new Subscription();
$memberModel = new Member();

$membership = $membershipModel->getMembershipById(
    $membershipId
);

if (!$membership) {

    http_response_code(404);
    die("Membership not found.");
}

$member = $memberModel->getByUserId($userId);

if (!$member) {

    http_response_code(403);
    die("Member profile not found.");
}

$memberId = (int) $member["member_id"];

$userSubscriptions =
    $subscriptionModel->getSubscriptionsByUserId($userId);

$hasSubscription = !empty($userSubscriptions);

$price = (float) $membership["price"];
$duration = (int) $membership["duration"];

$discountPercent = 0;
$offerTitle = "Membership";
$offerDescription = "Regular membership price.";

if ($offerType === "new-member" && !$hasSubscription) {

    $discountPercent = 20;
    $offerTitle = "New Member Offer";
    $offerDescription =
        "20% discount on your first membership.";

} elseif ($offerType === "annual" && $duration >= 12) {

    $discountPercent = 15;
    $offerTitle = "Annual Plan";
    $offerDescription =
        "15% discount for a 12-month membership.";

} elseif ($offerType === "long-term" && $duration >= 6) {

    $discountPercent = 10;
    $offerTitle = "Long-Term Plan";
    $offerDescription =
        "10% discount for memberships of 6 months or more.";
}

$discountAmount =
    $price * ($discountPercent / 100);

$finalPrice =
    $price - $discountAmount;

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $paymentMethod = trim(
        $_POST["payment_method"] ?? ""
    );

    $startDate = trim(
        $_POST["start_date"] ?? ""
    );

    if (
        $paymentMethod === "" ||
        $startDate === ""
    ) {

        $message =
            "Please complete all required fields.";

    } elseif ($startDate < date("Y-m-d")) {

        $message =
            "The start date cannot be earlier than today.";

    } else {

        $startTimestamp = strtotime($startDate);

        if ($startTimestamp === false) {

            $message =
                "The selected start date is invalid.";

        } else {

            $endDate = date(
                "Y-m-d",
                strtotime(
                    "+" . $duration . " months",
                    $startTimestamp
                )
            );

            $result =
                $subscriptionModel->createSubscriptionWithPayment(
                    $memberId,
                    $membershipId,
                    $startDate,
                    $endDate,
                    "Active",
                    date("Y-m-d"),
                    $finalPrice,
                    $paymentMethod,
                    "Paid"
                );

            if ($result) {

                header(
                    "Location: ../pages/members/dashboard.php"
                );

                exit;

            } else {

                $message =
                    "We could not complete your subscription. Please check your information and try again.";
            }
        }
    }
}

require_once __DIR__ . "/../includes/header.php";
?>

<main class="public-page subscribe-page">

    <section class="page-hero">

        <h1>Complete Your Membership</h1>

        <p>
            Review your membership and complete your payment.
        </p>

    </section>

    <section class="subscribe-section">

        <?php if ($message !== ""): ?>

            <div
                class="subscribe-message"
                role="alert"
            >
                ⚠
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>

        <div class="subscribe-grid">

            <!-- Membership Summary -->

            <div class="subscribe-summary">

                <span class="offer-label">
                    <?= htmlspecialchars($offerTitle) ?>
                </span>

                <h2>
                    <?= htmlspecialchars(
                        $membership["membership_name"]
                    ) ?>
                </h2>

                <p class="summary-note">
                    <?= htmlspecialchars($offerDescription) ?>
                </p>

                <div class="summary-row">

                    <span>
                        Duration
                    </span>

                    <strong>
                        <?= $duration ?> month(s)
                    </strong>

                </div>

                <div class="summary-row">

                    <span>
                        Original Price
                    </span>

                    <strong>
                        $<?= number_format($price, 2) ?>
                    </strong>

                </div>

                <?php if ($discountPercent > 0): ?>

                    <div class="summary-row discount-row">

                        <span>
                            Discount (<?= $discountPercent ?>%)
                        </span>

                        <strong>
                            -$<?= number_format(
                                $discountAmount,
                                2
                            ) ?>
                        </strong>

                    </div>

                <?php endif; ?>

                <div class="summary-divider"></div>

                <div class="summary-total">

                    <span>
                        Total
                    </span>

                    <strong>
                        $<?= number_format(
                            $finalPrice,
                            2
                        ) ?>
                    </strong>

                </div>

                <p class="summary-note">
                    ✓ Your discount is calculated automatically.
                </p>

            </div>


            <!-- Payment Form -->

            <div class="subscribe-form-card">

                <h2>
                    Payment Details
                </h2>

                <p>
                    Complete the form below to activate your membership.
                </p>

                <form
                    method="POST"
                    novalidate
                >

                    <div class="form-group">

                        <label for="start_date">

                            Start Date

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            min="<?= date("Y-m-d") ?>"
                            value="<?= htmlspecialchars(
                                $_POST["start_date"]
                                ?? date("Y-m-d")
                            ) ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="payment_method">

                            Payment Method

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <select
                            id="payment_method"
                            name="payment_method"
                            required
                        >

                            <option value="">
                                Select Payment Method
                            </option>

                            <option
                                value="Cash"
                                <?= (
                                    ($_POST["payment_method"] ?? "")
                                    === "Cash"
                                ) ? "selected" : "" ?>
                            >
                                Cash
                            </option>

                            <option
                                value="Card"
                                <?= (
                                    ($_POST["payment_method"] ?? "")
                                    === "Card"
                                ) ? "selected" : "" ?>
                            >
                                Card
                            </option>

                            <option
                                value="Bank Transfer"
                                <?= (
                                    ($_POST["payment_method"] ?? "")
                                    === "Bank Transfer"
                                ) ? "selected" : "" ?>
                            >
                                Bank Transfer
                            </option>

                        </select>

                    </div>


                    <div class="payment-final">

                        <span>
                            Amount to Pay
                        </span>

                        <strong>
                            $<?= number_format(
                                $finalPrice,
                                2
                            ) ?>
                        </strong>

                    </div>


                    <button
                        type="submit"
                        class="form-button"
                    >
                        Confirm & Pay
                    </button>


                    <a
                        href="offers.php"
                        class="back-link"
                    >
                        Cancel and Return to Offers
                    </a>

                </form>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>