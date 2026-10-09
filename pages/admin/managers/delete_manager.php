<?php

require_once __DIR__ . "/../../../classes/user.php";

$user = new User();


if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    header("Location: managers.php");
    exit;

}


$user_id = (int) $_GET["id"];


$manager = $user->getById($user_id);


// تأكد أن المستخدم Manager
if (!$manager || $manager["profile_id"] != 2) {

    header("Location: managers.php");
    exit;

}


$user->delete($user_id);


header("Location: managers.php");
exit;