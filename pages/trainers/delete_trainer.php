<?php

require_once __DIR__ . "/../../functions/helpers.php";
requirePermission("manage_trainers");

require_once __DIR__ . "/../../classes/trainer.php";

$trainer = new Trainer();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: trainers.php");
    exit;
}

$trainer_id = (int) $_GET["id"];

$result = $trainer->deleteTrainer($trainer_id);

if ($result) {
    header("Location: trainers.php?deleted=1");
    exit;
}

header("Location: trainers.php?deleted=0");
exit;