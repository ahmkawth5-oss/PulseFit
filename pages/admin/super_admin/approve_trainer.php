<?php

require_once __DIR__ . "/../../../classes/trainer.php";

$trainer = new Trainer();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: dashboard.php");
    exit;
}

$trainer_id = $_GET["id"];

$result = $trainer->approveTrainer($trainer_id);

header("Location: dashboard.php");
exit;