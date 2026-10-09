<?php

require_once __DIR__ . "/../../functions/helpers.php";
requirePermission("manage_members");

require_once __DIR__ . "/../../classes/member.php";

$member = new Member();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: members.php");
    exit;
}

$member_id = $_GET["id"];

$member->deleteMember($member_id);

header("Location: members.php");
exit;