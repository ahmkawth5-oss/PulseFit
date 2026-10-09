<?php

require_once __DIR__ . "/../../classes/gym_class.php";
require_once __DIR__ . "/../../functions/helpers.php";

requireLogin();

$class = new ClassModel();

$profile_id = (int) $_SESSION["profile_id"];


// =========================
// Get Classes According To Profile
// =========================

if ($profile_id === 3) {

    require_once __DIR__ . "/../../classes/trainer.php";

    $trainer = new Trainer();

    $trainerData = $trainer->getTrainerByUserId($_SESSION["user_id"]);

    if (!$trainerData) {
        die("Trainer profile not found.");
    }

    $classes = $class->getClassesByTrainerId(
        $trainerData["trainer_id"]
    );

} else {

    $classes = $class->getAllClasses();
}


// =========================
// Get Class By ID
// =========================

$classRecord = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["class_id"])) {

    $class_id = trim($_POST["class_id"]);

    if (is_numeric($class_id)) {

        $requestedClass = $class->getClassById($class_id);

        if ($requestedClass) {

            if ($profile_id === 3) {

                if (
                    (int) $requestedClass["trainer_id"]
                    === (int) $trainerData["trainer_id"]
                ) {
                    $classRecord = $requestedClass;
                }

            } else {

                $classRecord = $requestedClass;
            }
        }
    }
}


// =========================
// Check Management Permission
// =========================

$canManageClasses = hasPermission("manage_classes");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Classes - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>

<body>

<div class="main-content">

    <div class="dashboard-header">

        <h1>Classes</h1>

        <?php if ($profile_id === 3): ?>

            <p>View your assigned gym classes</p>

        <?php elseif ($profile_id === 4): ?>

            <p>View available gym classes</p>

        <?php else: ?>

            <p>Manage gym classes</p>

        <?php endif; ?>

    </div>


    <?php if ($canManageClasses): ?>

        <a href="add_class.php">
            Add Class
        </a>

    <?php endif; ?>


    <table>

        <tr>

            <th>ID</th>

            <th>Class Name</th>

            <th>Class Date</th>

            <th>Start Time</th>

            <th>Capacity</th>

            <th>Trainer</th>

            <?php if ($canManageClasses): ?>

                <th>Actions</th>

            <?php endif; ?>

        </tr>


        <?php if (!empty($classes)): ?>

            <?php foreach ($classes as $item): ?>

                <tr>

                    <td>
                        <?= $item["class_id"] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $item["class_name"]
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $item["class_date"]
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $item["start_time"]
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $item["capacity"]
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $item["full_name"]
                        ) ?>
                    </td>


                    <?php if ($canManageClasses): ?>

                        <td>

                            <div class="table-actions">

                                <a
                                    href="edit_class.php?id=<?= $item["class_id"] ?>"
                                    class="edit-button"
                                >
                                    Edit
                                </a>

                                <a
                                    href="delete_class.php?id=<?= $item["class_id"] ?>"
                                    class="delete-button"
                                    onclick="return confirm('Are you sure you want to delete this class?');"
                                >
                                    Delete
                                </a>

                            </div>

                        </td>

                    <?php endif; ?>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>

                <td
                    colspan="<?= $canManageClasses ? 7 : 6 ?>"
                >
                    No classes found.
                </td>

            </tr>

        <?php endif; ?>

    </table>


    <!-- Get Class By ID -->

    <div class="form-container">

        <h2>Get Class By ID</h2>

        <form method="POST">

            <div class="form-group">

                <label for="class_id">
                    Class ID
                </label>

                <input
                    type="number"
                    id="class_id"
                    name="class_id"
                    min="1"
                    required
                >

            </div>

            <button type="submit">
                Get Class
            </button>

        </form>

    </div>


    <?php if ($classRecord): ?>

        <div class="record-container">

            <h2>Class Record</h2>

            <table>

                <tr>

                    <th>ID</th>

                    <th>Class Name</th>

                    <th>Class Date</th>

                    <th>Start Time</th>

                    <th>Capacity</th>

                    <th>Trainer ID</th>

                </tr>

                <tr>

                    <td>
                        <?= $classRecord["class_id"] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $classRecord["class_name"]
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $classRecord["class_date"]
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $classRecord["start_time"]
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $classRecord["capacity"]
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $classRecord["trainer_id"]
                        ) ?>
                    </td>

                </tr>

            </table>

        </div>

    <?php endif; ?>

</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>