<?php

session_start();

require_once __DIR__ . "/../../classes/subscription.php";
require_once __DIR__ . "/../../classes/member.php";
require_once __DIR__ . "/../../classes/membership.php";


// ==========================================
// Check Login
// ==========================================

if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["profile_id"])
) {
    header("Location: ../../auth/login.php");
    exit;
}


$profile_id = (int) $_SESSION["profile_id"];


// ==========================================
// Only Admin and Manager
// ==========================================

if ($profile_id !== 1 && $profile_id !== 2) {

    http_response_code(403);

    die("Access Denied");
}


$subscription = new Subscription();
$member = new Member();
$membership = new Membership();


// ==========================================
// Validate Subscription ID
// ==========================================

if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {

    header("Location: subscriptions.php");
    exit;
}


$subscription_id = (int) $_GET["id"];

$data = $subscription->getSubscriptionById(
    $subscription_id
);


if (!$data) {

    header("Location: subscriptions.php");
    exit;
}


$members = $member->getAll();
$memberships = $membership->getAllMemberships();

$message = "";


// ==========================================
// Update Subscription
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $member_id = $_POST["member_id"] ?? "";
    $membership_id = $_POST["membership_id"] ?? "";
    $start_date = $_POST["start_date"] ?? "";
    $end_date = $_POST["end_date"] ?? "";
    $status = $_POST["status"] ?? "";


    if (
        $member_id === "" ||
        $membership_id === "" ||
        $start_date === "" ||
        $end_date === "" ||
        $status === ""
    ) {

        $message = "Please fill in all required fields.";

    } else {

        $result = $subscription->updateSubscription(
            $subscription_id,
            (int) $member_id,
            (int) $membership_id,
            $start_date,
            $end_date,
            $status
        );


        if ($result !== false) {

            header("Location: subscriptions.php");
            exit;

        }


        $message = "Failed to update subscription.";
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

    <title>Edit Subscription - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>

<div class="main-content">


    <div class="dashboard-header">

        <h1>
            Edit Subscription
        </h1>

        <p>
            Update member subscription
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

                <select
                    id="member_id"
                    name="member_id"
                    required
                >

                    <?php foreach ($members as $item): ?>

                        <option
                            value="<?= $item["member_id"] ?>"
                            <?= (
                                ($_POST["member_id"]
                                    ?? $data["member_id"])
                                == $item["member_id"]
                            )
                                ? "selected"
                                : ""
                            ?>
                        >

                            <?= htmlspecialchars(
                                $item["full_name"]
                            ) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="form-group">

                <label for="membership_id">
                    Membership
                </label>

                <select
                    id="membership_id"
                    name="membership_id"
                    required
                >

                    <?php foreach ($memberships as $item): ?>

                        <option
                            value="<?= $item["membership_id"] ?>"
                            <?= (
                                ($_POST["membership_id"]
                                    ?? $data["membership_id"])
                                == $item["membership_id"]
                            )
                                ? "selected"
                                : ""
                            ?>
                        >

                            <?= htmlspecialchars(
                                $item["membership_name"]
                            ) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="form-group">

                <label for="start_date">
                    Start Date
                </label>

                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["start_date"]
                        ?? $data["start_date"]
                    ) ?>"
                >

            </div>


            <div class="form-group">

                <label for="end_date">
                    End Date
                </label>

                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["end_date"]
                        ?? $data["end_date"]
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
                        value="Active"
                        <?= (
                            ($_POST["status"]
                                ?? $data["status"])
                            === "Active"
                        )
                            ? "selected"
                            : ""
                        ?>
                    >
                        Active
                    </option>


                    <option
                        value="Expired"
                        <?= (
                            ($_POST["status"]
                                ?? $data["status"])
                            === "Expired"
                        )
                            ? "selected"
                            : ""
                        ?>
                    >
                        Expired
                    </option>


                    <option
                        value="Cancelled"
                        <?= (
                            ($_POST["status"]
                                ?? $data["status"])
                            === "Cancelled"
                            )
                            ? "selected"
                            : ""
                        ?>
                    >
                        Cancelled
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Update Subscription
            </button>


            <div>

                <a
                    href="subscriptions.php"
                    class="back-link"
                >
                    Back to Subscriptions
                </a>

            </div>


        </form>

    </div>


</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>