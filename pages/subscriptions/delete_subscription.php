<?php

session_start();

require_once __DIR__ . "/../../classes/subscription.php";


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

$subscription = new Subscription();


// ==========================================
// Delete Subscription
// ==========================================

$subscription->deleteSubscription(
    $subscription_id
);


header("Location: subscriptions.php");
exit;