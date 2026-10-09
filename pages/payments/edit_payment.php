<?php

require_once __DIR__ . "/../../classes/payment.php";
require_once __DIR__ . "/../../classes/subscription.php";

$payment = new Payment();
$subscription = new Subscription();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: payments.php");
    exit;
}

$payment_id = $_GET["id"];

$data = $payment->getPaymentById($payment_id);

if (!$data) {
    header("Location: payments.php");
    exit;
}

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

        $result = $payment->updatePayment(
            $payment_id,
            $payment_date,
            $amount,
            $payment_method,
            $payment_status,
            $subscription_id
        );

        if ($result !== false) {

            header("Location: payments.php");
            exit;

        }

        $message = "Failed to update payment.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Payment - PulseFit</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

    <div class="main-content">

        <div class="dashboard-header">

            <h1>Edit Payment</h1>

            <p>Update subscription payment</p>

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

                        <?php foreach ($subscriptions as $item): ?>

                            <option
                                value="<?= $item["subscription_id"] ?>"
                                <?= (
                                    ($_POST["subscription_id"] ?? $data["subscription_id"])
                                    == $item["subscription_id"]
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
                        value="<?= htmlspecialchars(
                            $_POST["payment_date"]
                            ?? $data["payment_date"]
                        ) ?>"
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
                        value="<?= htmlspecialchars(
                            $_POST["amount"]
                            ?? $data["amount"]
                        ) ?>"
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

                        <option
                            value="Cash"
                            <?= (
                                ($_POST["payment_method"]
                                ?? $data["payment_method"]) === "Cash"
                            ) ? "selected" : "" ?>
                        >
                            Cash
                        </option>

                        <option
                            value="Card"
                            <?= (
                                ($_POST["payment_method"]
                                ?? $data["payment_method"]) === "Card"
                            ) ? "selected" : "" ?>
                        >
                            Card
                        </option>

                        <option
                            value="Bank Transfer"
                            <?= (
                                ($_POST["payment_method"]
                                ?? $data["payment_method"]) === "Bank Transfer"
                            ) ? "selected" : "" ?>
                        >
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

                        <option
                            value="Paid"
                            <?= (
                                ($_POST["payment_status"]
                                ?? $data["payment_status"]) === "Paid"
                            ) ? "selected" : "" ?>
                        >
                            Paid
                        </option>

                        <option
                            value="Pending"
                            <?= (
                                ($_POST["payment_status"]
                                ?? $data["payment_status"]) === "Pending"
                            ) ? "selected" : "" ?>
                        >
                            Pending
                        </option>

                        <option
                            value="Failed"
                            <?= (
                                ($_POST["payment_status"]
                                ?? $data["payment_status"]) === "Failed"
                            ) ? "selected" : "" ?>
                        >
                            Failed
                        </option>

                    </select>

                </div>


                <button
                    type="submit"
                    class="form-button"
                >
                    Update Payment
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