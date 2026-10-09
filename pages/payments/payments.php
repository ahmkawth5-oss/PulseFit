<?php

require_once __DIR__ . "/../../classes/payment.php";

$payment = new Payment();

$payments = $payment->getAllPayments();

$paymentRecord = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["payment_id"])) {

    $payment_id = trim($_POST["payment_id"]);

    if (is_numeric($payment_id)) {
        $paymentRecord = $payment->getPaymentById($payment_id);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payments - PulseFit</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

    <div class="main-content">

        <div class="dashboard-header">

            <h1>Payments</h1>

            <p>Manage subscription payments</p>

        </div>


        <a href="add_payment.php">
            Add Payment
        </a>


        <table>

            <tr>

                <th>ID</th>
                <th>Member</th>
                <th>Membership</th>
                <th>Payment Date</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Actions</th>

            </tr>


            <?php foreach ($payments as $item): ?>

                <tr>

                    <td>
                        <?= $item["payment_id"] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["full_name"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["membership_name"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["payment_date"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["amount"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["payment_method"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["payment_status"]) ?>
                    </td>

                    <td>

                        <div class="table-actions">

                            <a
                                href="edit_payment.php?id=<?= $item["payment_id"] ?>"
                                class="edit-button"
                            >
                                Edit
                            </a>

                            <a
                                href="delete_payment.php?id=<?= $item["payment_id"] ?>"
                                class="delete-button"
                                onclick="return confirm('Are you sure you want to delete this payment?');"
                            >
                                Delete
                            </a>

                        </div>

                    </td>

                </tr>

            <?php endforeach; ?>

        </table>


            <!-- get by id -->
        <div class="form-container">

    <h2>Get Payment By ID</h2>

    <form method="POST">
        
        <div class="form-group">
        <label for="payment_id">Payment ID</label>

        <input
            type="number"
            id="payment_id"
            name="payment_id"
            min="1"
            required
        >
        </div>

        <button type="submit">
            Get Payment
        </button>

    </form>

</div>


<?php if ($paymentRecord): ?>

<div class="record-container">

    <h2>Payment Record</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Payment Date</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Subscription ID</th>
        </tr>

        <tr>

            <td><?= $paymentRecord["payment_id"] ?></td>

            <td><?= htmlspecialchars($paymentRecord["payment_date"]) ?></td>

            <td><?= htmlspecialchars($paymentRecord["amount"]) ?></td>

            <td><?= htmlspecialchars($paymentRecord["payment_method"]) ?></td>

            <td><?= htmlspecialchars($paymentRecord["payment_status"]) ?></td>

            <td><?= $paymentRecord["subscription_id"] ?></td>

        </tr>

    </table>

</div>

<?php endif; ?>

</div>

<script src="../../assets/js/theme.js"></script>

</body>

</html>