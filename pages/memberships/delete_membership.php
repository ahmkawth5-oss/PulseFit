<?php

require_once __DIR__ . "/../../classes/membership.php";

$membership = new Membership();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: memberships.php");
    exit;
}

$membership_id = $_GET["id"];

$result = $membership->deleteMembership($membership_id);

header("Location: memberships.php");
exit;