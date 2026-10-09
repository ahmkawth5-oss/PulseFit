<?php

require_once __DIR__ . "/../../classes/payment.php";

$payment = new Payment();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: payments.php");
    exit;
}

$payment_id = $_GET["id"];

$payment->deletePayment($payment_id);

header("Location: payments.php");
exit;