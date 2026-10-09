<?php

require_once __DIR__ . "/../../functions/helpers.php";
require_once __DIR__ . "/../../classes/gym_class.php";

requirePermission("manage_classes");

$class = new ClassModel();


if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    header("Location: classes.php");
    exit;
}


$class_id = (int) $_GET["id"];


$class->deleteClass($class_id);


header("Location: classes.php");
exit;