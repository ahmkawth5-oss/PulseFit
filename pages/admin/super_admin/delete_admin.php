<?php

require_once __DIR__ . "/../../../classes/user.php";
require_once __DIR__ . "/../../../functions/image_helper.php";

$user = new User();

if (
    !isset($_GET["id"])
    || !is_numeric($_GET["id"])
) {

    header("Location: admins.php");
    exit;

}

$user_id = (int) $_GET["id"];

$admin = $user->getById($user_id);


// Make sure the selected user is actually an Admin

if (
    !$admin
    || $admin["profile_id"] != 1
) {

    header("Location: admins.php");
    exit;

}


// Delete profile image

if (!empty($admin["image"])) {
    deleteUserImage($admin["image"]);
}


// Delete admin

$user->delete($user_id);


header("Location: admins.php");
exit;