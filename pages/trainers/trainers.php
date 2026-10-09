<?php

require_once __DIR__ . "/../../functions/helpers.php";
requirePermission("manage_trainers");

require_once __DIR__ . "/../../classes/trainer.php";

$trainer = new Trainer();

$trainers = $trainer->getAllTrainers();

$trainerRecord = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["trainer_id"])) {

    $trainer_id = trim($_POST["trainer_id"]);

    if (is_numeric($trainer_id)) {
        $trainerRecord = $trainer->getTrainerById($trainer_id);
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

    <title>Trainers - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>

<body>

<div class="main-content">

    <div class="dashboard-header">

        <h1>
            Trainers
        </h1>

        <p>
            Manage gym trainers
        </p>

    </div>


    <a href="add_trainer.php">
        Add Trainer
    </a>


    <table>

        <tr>

            <th>ID</th>
            <th>Photo</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Specialty</th>
            <th>Birth Date</th>
            <th>Hire Date</th>
            <th>Salary</th>
            <th>Status</th>
            <th>Actions</th>

        </tr>


        <?php foreach ($trainers as $item): ?>

            <tr>

                <td>
                    <?= $item["trainer_id"] ?>
                </td>


                <td>

                    <?php if (!empty($item["image"])): ?>

                        <img
                            src="/PulseFit/uploads/users/<?= htmlspecialchars($item["image"]) ?>"
                            alt="Trainer Photo"
                            style="
                                width: 50px;
                                height: 50px;
                                object-fit: cover;
                                border-radius: 50%;
                            "
                        >

                    <?php else: ?>

                        No Photo

                    <?php endif; ?>

                </td>


                <td>
                    <?= htmlspecialchars($item["full_name"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["username"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["phone"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["email"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["specialty"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["birth_date"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["hire_date"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["salary"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["status"]) ?>
                </td>


                <td>

                    <div class="table-actions">

                        <a
                            href="edit_trainer.php?id=<?= $item["trainer_id"] ?>"
                            class="edit-button"
                        >
                            Edit
                        </a>

                        <a
                            href="delete_trainer.php?id=<?= $item["trainer_id"] ?>"
                            class="delete-button"
                            onclick="return confirm('Are you sure you want to delete this trainer?');"
                        >
                            Delete
                        </a>

                    </div>

                </td>

            </tr>

        <?php endforeach; ?>

    </table>


    <div class="form-container">

        <h2>
            Get Trainer By ID
        </h2>

        <form method="POST">

            <div class="form-group">

                <label for="trainer_id">
                    Trainer ID
                </label>

                <input
                    type="number"
                    id="trainer_id"
                    name="trainer_id"
                    min="1"
                    required
                >

            </div>

            <button type="submit">
                Get Trainer
            </button>

        </form>

    </div>


    <?php if ($trainerRecord): ?>

        <div class="record-container">

            <h2>
                Trainer Record
            </h2>

            <table>

                <tr>

                    <th>ID</th>
                    <th>Photo</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Specialty</th>
                    <th>Birth Date</th>
                    <th>Hire Date</th>
                    <th>Salary</th>
                    <th>Status</th>

                </tr>


                <tr>

                    <td>
                        <?= $trainerRecord["trainer_id"] ?>
                    </td>


                    <td>

                        <?php if (!empty($trainerRecord["image"])): ?>

                            <img
                                src="/PulseFit/uploads/users/<?= htmlspecialchars($trainerRecord["image"]) ?>"
                                alt="Trainer Photo"
                                style="
                                    width: 70px;
                                    height: 70px;
                                    object-fit: cover;
                                    border-radius: 50%;
                                "
                            >

                        <?php else: ?>

                            No Photo

                        <?php endif; ?>

                    </td>


                    <td>
                        <?= htmlspecialchars($trainerRecord["full_name"]) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($trainerRecord["username"]) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($trainerRecord["phone"]) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($trainerRecord["email"]) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($trainerRecord["specialty"]) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($trainerRecord["birth_date"]) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($trainerRecord["hire_date"]) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($trainerRecord["salary"]) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($trainerRecord["status"]) ?>
                    </td>

                </tr>

            </table>

        </div>

    <?php endif; ?>


</div>

</body>

</html>