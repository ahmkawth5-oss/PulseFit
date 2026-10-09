<?php

require_once __DIR__ . "/../../functions/helpers.php";
requirePermission("manage_trainers");

require_once __DIR__ . "/../../functions/image_helper.php";
require_once __DIR__ . "/../../classes/trainer.php";

$trainer = new Trainer();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $specialty = trim($_POST["specialty"]);
    $hire_date = $_POST["hire_date"];
    $salary = $_POST["salary"];
    $birth_date = $_POST["birth_date"];

    if (
        $full_name === "" ||
        $username === "" ||
        $password === "" ||
        $specialty === "" ||
        $hire_date === "" ||
        $salary === "" ||
        $birth_date === ""
    ) {

        $message = "Please fill in all required fields.";

    } elseif ($salary < 0) {

        $message = "Salary cannot be negative.";

    } else {

        $image = uploadUserImage($_FILES["image"] ?? null);

        if ($image === false) {

            $message = "Invalid image. Please upload JPG, PNG, or WebP up to 5 MB.";

        } else {

            $result = $trainer->createTrainer(
                $full_name,
                $username,
                $password,
                $phone,
                $email,
                $specialty,
                $hire_date,
                $salary,
                $birth_date,
                $image
            );

            if ($result) {

                header("Location: trainers.php");
                exit;

            } else {

                if ($image !== null) {
                    deleteUserImage($image);
                }

                $message = "Failed to add trainer.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Trainer - PulseFit</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

    <div class="main-content">

        <div class="dashboard-header">

            <h1>Add Trainer</h1>

            <p>Create a new gym trainer</p>

        </div>

        <?php if (!empty($message)): ?>

            <div class="error-message">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>

        <div class="form-container">

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">

                    <label for="full_name">Full Name</label>

                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        required
                        value="<?= htmlspecialchars($_POST["full_name"] ?? "") ?>"
                    >

                </div>

                <div class="form-group">

                    <label for="username">Username</label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        required
                        value="<?= htmlspecialchars($_POST["username"] ?? "") ?>"
                    >

                </div>

                <div class="form-group">

                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="phone">Phone</label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="<?= htmlspecialchars($_POST["phone"] ?? "") ?>"
                    >

                </div>

                <div class="form-group">

                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                    >

                </div>

                <div class="form-group">

                    <label for="specialty">Specialty</label>

                    <input
                        type="text"
                        id="specialty"
                        name="specialty"
                        required
                        value="<?= htmlspecialchars($_POST["specialty"] ?? "") ?>"
                    >

                </div>

                <div class="form-group">

                    <label for="birth_date">Birth Date</label>

                    <input
                        type="date"
                        id="birth_date"
                        name="birth_date"
                        required
                        value="<?= htmlspecialchars($_POST["birth_date"] ?? "") ?>"
                    >

                </div>

                <div class="form-group">

                    <label for="hire_date">Hire Date</label>

                    <input
                        type="date"
                        id="hire_date"
                        name="hire_date"
                        required
                        value="<?= htmlspecialchars($_POST["hire_date"] ?? date("Y-m-d")) ?>"
                    >

                </div>

                <div class="form-group">

                    <label for="salary">Salary</label>

                    <input
                        type="number"
                        id="salary"
                        name="salary"
                        min="0"
                        step="0.01"
                        required
                        value="<?= htmlspecialchars($_POST["salary"] ?? "") ?>"
                    >

                </div>

                <div class="form-group">

                    <label for="image">
                        Profile Image
                        <span>(optional)</span>
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small>
                        JPG, PNG, or WebP. Maximum size: 5 MB.
                    </small>

                </div>

                <button
                    type="submit"
                    class="form-button"
                >
                    Add Trainer
                </button>

                <div>

                    <a
                        href="trainers.php"
                        class="back-link"
                    >
                        Back to Trainers
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>