<?php

require_once __DIR__ . "/../../functions/helpers.php";
require_once __DIR__ . "/../../classes/gym_class.php";
require_once __DIR__ . "/../../classes/trainer.php";

requirePermission("manage_classes");

$class = new ClassModel();
$trainer = new Trainer();

$trainers = $trainer->getAllTrainers();

$message = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $class_name = trim($_POST["class_name"] ?? "");
    $class_date = $_POST["class_date"] ?? "";
    $start_time = $_POST["start_time"] ?? "";
    $capacity = $_POST["capacity"] ?? "";
    $trainer_id = $_POST["trainer_id"] ?? "";


    if (
        $class_name === "" ||
        $class_date === "" ||
        $start_time === "" ||
        $capacity === "" ||
        $trainer_id === ""
    ) {

        $message = "Please fill in all required fields.";

    } elseif ((int) $capacity <= 0) {

        $message = "Capacity must be greater than zero.";

    } else {

        $result = $class->createClass(
            $class_name,
            $class_date,
            $start_time,
            (int) $capacity,
            (int) $trainer_id
        );

        if ($result) {

            header("Location: classes.php");
            exit;

        }

        $message = "Failed to add class.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Class - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>

<body>

<div class="main-content">

    <div class="dashboard-header">

        <h1>Add Class</h1>

        <p>Create a new gym class</p>

    </div>


    <?php if ($message !== ""): ?>

        <div class="auth-message">

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>


    <div class="form-container">

        <form method="POST">

            <div class="form-group">

                <label for="class_name">
                    Class Name
                </label>

                <input
                    type="text"
                    id="class_name"
                    name="class_name"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["class_name"] ?? ""
                    ) ?>"
                >

            </div>


            <div class="form-group">

                <label for="class_date">
                    Class Date
                </label>

                <input
                    type="date"
                    id="class_date"
                    name="class_date"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["class_date"] ?? ""
                    ) ?>"
                >

            </div>


            <div class="form-group">

                <label for="start_time">
                    Start Time
                </label>

                <input
                    type="time"
                    id="start_time"
                    name="start_time"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["start_time"] ?? ""
                    ) ?>"
                >

            </div>


            <div class="form-group">

                <label for="capacity">
                    Capacity
                </label>

                <input
                    type="number"
                    id="capacity"
                    name="capacity"
                    min="1"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["capacity"] ?? ""
                    ) ?>"
                >

            </div>


            <div class="form-group">

                <label for="trainer_id">
                    Trainer
                </label>

                <select
                    id="trainer_id"
                    name="trainer_id"
                    required
                >

                    <option value="">
                        Select Trainer
                    </option>

                    <?php foreach ($trainers as $item): ?>

                        <option
                            value="<?= $item["trainer_id"] ?>"
                            <?= (
                                ($_POST["trainer_id"] ?? "")
                                == $item["trainer_id"]
                            ) ? "selected" : "" ?>
                        >
                            <?= htmlspecialchars(
                                $item["full_name"]
                            ) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Add Class
            </button>


            <div>

                <a
                    href="classes.php"
                    class="back-link"
                >
                    Back to Classes
                </a>

            </div>

        </form>

    </div>

</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>