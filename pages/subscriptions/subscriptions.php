<?php

session_start();

require_once __DIR__ . "/../../classes/subscription.php";
require_once __DIR__ . "/../../classes/member.php";


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
$user_id = (int) $_SESSION["user_id"];

$subscription = new Subscription();


// ==========================================
// Load Subscriptions According To Profile
// ==========================================

if ($profile_id === 1 || $profile_id === 2) {

    // Admin and Manager can see all subscriptions
    $subscriptions = $subscription->getAllSubscriptions();

} elseif ($profile_id === 4) {

    // Member can see only their own subscriptions
    $subscriptions = $subscription->getSubscriptionsByUserId($user_id);

} else {

    // Trainer and any unknown profile have no access
    http_response_code(403);
    die("Access Denied");
}


// ==========================================
// Get Subscription By ID
// ==========================================

$subscriptionRecord = null;

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["subscription_id"])
) {

    $subscription_id = trim($_POST["subscription_id"]);

    if (is_numeric($subscription_id)) {

        $subscription_id = (int) $subscription_id;

        $record = $subscription->getSubscriptionById(
            $subscription_id
        );


        // ==========================================
        // Admin and Manager
        // ==========================================

        if ($profile_id === 1 || $profile_id === 2) {

            $subscriptionRecord = $record;

        }


        // ==========================================
        // Member
        // ==========================================

        elseif ($profile_id === 4) {

            if (
                $record &&
                (int) $record["user_id"] === $user_id
            ) {

                $subscriptionRecord = $record;
            }
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

    <title>Subscriptions - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>

<div class="main-content">


    <div class="dashboard-header">

        <h1>
            Subscriptions
        </h1>

        <p>
            <?= (
                $profile_id === 4
            )
                ? "View your subscriptions"
                : "Manage member subscriptions"
            ?>
        </p>

    </div>


    <?php if ($profile_id === 1 || $profile_id === 2): ?>

        <a href="add_subscription.php">
            Add Subscription
        </a>

    <?php endif; ?>


    <!-- Subscription Table -->

    <table>

        <tr>

            <th>ID</th>

            <th>Member</th>

            <th>Membership</th>

            <th>Start Date</th>

            <th>End Date</th>

            <th>Status</th>

            <?php if ($profile_id === 1 || $profile_id === 2): ?>

                <th>Actions</th>

            <?php endif; ?>

        </tr>


        <?php if (!empty($subscriptions)): ?>

            <?php foreach ($subscriptions as $item): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars(
                            $item["subscription_id"]
                        ) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $item["full_name"]
                        ) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $item["membership_name"]
                        ) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $item["start_date"]
                        ) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $item["end_date"]
                        ) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $item["status"]
                        ) ?>
                    </td>


                    <?php if ($profile_id === 1 || $profile_id === 2): ?>

                        <td>

                            <div class="table-actions">

                                <a
                                    href="edit_subscription.php?id=<?= $item["subscription_id"] ?>"
                                    class="edit-button"
                                >
                                    Edit
                                </a>


                                <a
                                    href="delete_subscription.php?id=<?= $item["subscription_id"] ?>"
                                    class="delete-button"
                                    onclick="return confirm('Are you sure you want to delete this subscription?');"
                                >
                                    Delete
                                </a>

                            </div>

                        </td>

                    <?php endif; ?>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>

                <td
                    colspan="<?= (
                        $profile_id === 1 || $profile_id === 2
                    ) ? "7" : "6" ?>"
                >

                    No subscriptions found.

                </td>

            </tr>

        <?php endif; ?>

    </table>


    <!-- Get Subscription By ID -->

    <div class="form-container">

        <h2>
            Get Subscription By ID
        </h2>


        <form method="POST">

            <div class="form-group">

                <label for="subscription_id">
                    Subscription ID
                </label>

                <input
                    type="number"
                    id="subscription_id"
                    name="subscription_id"
                    min="1"
                    required
                >

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Get Subscription
            </button>

        </form>

    </div>


    <!-- Single Subscription Record -->

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>

        <?php if ($subscriptionRecord): ?>

            <div class="record-container">

                <h2>
                    Subscription Record
                </h2>


                <table>

                    <tr>

                        <th>ID</th>

                        <th>Member ID</th>

                        <th>Membership ID</th>

                        <th>Start Date</th>

                        <th>End Date</th>

                        <th>Status</th>

                    </tr>


                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $subscriptionRecord["subscription_id"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $subscriptionRecord["member_id"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $subscriptionRecord["membership_id"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $subscriptionRecord["start_date"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $subscriptionRecord["end_date"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $subscriptionRecord["status"]
                            ) ?>
                        </td>

                    </tr>

                </table>

            </div>


        <?php else: ?>

            <div class="auth-message">

                Subscription record not found or access denied.

            </div>

        <?php endif; ?>

    <?php endif; ?>


</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>