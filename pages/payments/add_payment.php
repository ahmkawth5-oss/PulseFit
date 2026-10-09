<?php

require_once __DIR__ . "/../../classes/payment.php";
require_once __DIR__ . "/../../classes/subscription.php";

$payment = new Payment();
$subscription = new Subscription();

$subscriptions = $subscription->getAllSubscriptions();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $payment_date = $_POST["payment_date"];
    $amount = $_POST["amount"];
    $payment_method = $_POST["payment_method"];
    $payment_status = $_POST["payment_status"];
    $subscription_id = $_POST["subscription_id"];

    if (
        $payment_date === "" ||
        $amount === "" ||
        $payment_method === "" ||
        $payment_status === "" ||
        $subscription_id === ""
    ) {
        $message = "Please fill in all required fields.";
    } else {

        $result = $payment->createPayment(
            $payment_date,
            $amount,
            $payment_method,
            $payment_status,
            $subscription_id
        );

        if ($result) {

            header("Location: payments.php");
            exit;

        }

        $message = "Failed to add payment.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Payment - PulseFit</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

    <div class="main-content">

        <div class="dashboard-header">

            <h1>Add Payment</h1>

            <p>Record a new subscription payment</p>

        </div>


        <?php if ($message !== ""): ?>

            <div class="auth-message">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>


        <div class="form-container">

            <form method="POST">

                <div class="form-group">

                    <label for="subscription_id">
                        Subscription
                    </label>

                    <select
                        id="subscription_id"
                        name="subscription_id"
                        required
                    >

                        <option value="">
                            Select Subscription
                        </option>

                        <?php foreach ($subscriptions as $item): ?>

                            <option
                                value="<?= $item["subscription_id"] ?>"
                                <?= (
                                    ($_POST["subscription_id"] ?? "") == $item["subscription_id"]
                                ) ? "selected" : "" ?>
                            >
                                <?= htmlspecialchars(
                                    $item["full_name"]
                                    . " - "
                                    . $item["membership_name"]
                                ) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="form-group">

                    <label for="payment_date">
                        Payment Date
                    </label>

                    <input
                        type="date"
                        id="payment_date"
                        name="payment_date"
                        required
                        value="<?= htmlspecialchars($_POST["payment_date"] ?? "") ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="amount">
                        Amount
                    </label>

                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        min="0"
                        step="0.01"
                        required
                        value="<?= htmlspecialchars($_POST["amount"] ?? "") ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="payment_method">
                        Payment Method
                    </label>

                    <select
                        id="payment_method"
                        name="payment_method"
                        required
                    >

                        <option value="">
                            Select Payment Method
                        </option>

                        <option value="Cash">
                            Cash
                        </option>

                        <option value="Card">
                            Card
                        </option>

                        <option value="Bank Transfer">
                            Bank Transfer
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="payment_status">
                        Payment Status
                    </label>

                    <select
                        id="payment_status"
                        name="payment_status"
                        required
                    >

                        <option value="">
                            Select Status
                        </option>

                        <option value="Paid">
                            Paid
                        </option>

                        <option value="Pending">
                            Pending
                        </option>

                        <option value="Failed">
                            Failed
                        </option>

                    </select>

                </div>


                <button
                    type="submit"
                    class="form-button"
                >
                    Add Payment
                </button>


                <div>

                    <a
                        href="payments.php"
                        class="back-link"
                    >
                        Back to Payments
                    </a>

                </div>

            </form>

        </div>

</div>

<script src="../../assets/js/theme.js"></script>

</body>

</html>