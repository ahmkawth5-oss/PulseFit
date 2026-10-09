<?php

require_once __DIR__ . "/../../../classes/user.php";
require_once __DIR__ . "/../../../functions/image_helper.php";

$user = new User();

if (
    !isset($_GET["id"])
    || !is_numeric($_GET["id"])
) {
    header("Location: managers.php");
    exit;
}

$user_id = (int) $_GET["id"];

$manager = $user->getById($user_id);

if (
    !$manager
    || $manager["profile_id"] != 2
) {
    header("Location: managers.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $status = $_POST["status"];

    $image = uploadUserImage(
        $_FILES["image"] ?? null
    );

    if ($image === false) {

        $message = "Invalid image. Please upload JPG, PNG, or WebP up to 5 MB.";

    } elseif (
        $full_name === "" ||
        $username === "" ||
        $phone === "" ||
        $email === "" ||
        $status === ""
    ) {

        if ($image !== null) {
            deleteUserImage($image);
        }

        $message = "Please fill in all fields.";

    } else {

        $result = $user->update(
            $user_id,
            $full_name,
            $username,
            "Manager",
            2,
            $phone,
            $email,
            $status
        );

        /*
         * updateQuery() returns affected_rows.
         * 0 means the data was already the same, not that the query failed.
         */

        if ($result !== false) {

            if ($image !== null) {

                $oldImage = $manager["image"];

                $imageUpdated = $user->updateImage(
                    $user_id,
                    $image
                );

                if ($imageUpdated !== false) {

                    if (!empty($oldImage)) {
                        deleteUserImage($oldImage);
                    }

                } else {

                    deleteUserImage($image);

                    $message = "Manager information updated, but image update failed.";
                }
            }

            if ($message === "") {
                header("Location: managers.php");
                exit;
            }

        } else {

            if ($image !== null) {
                deleteUserImage($image);
            }

            $message = "Failed to update manager.";
        }
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

    <title>Edit Manager - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../../assets/css/style.css"
    >

</head>

<body>

<div class="main-content">

    <div class="dashboard-header">

        <h1>
            Edit Manager
        </h1>

        <p>
            Update manager information
        </p>

    </div>

    <?php if ($message !== ""): ?>

        <div class="auth-message">

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>

    <div class="form-container">

        <form
            method="POST"
            enctype="multipart/form-data"
        >

            <!-- Full Name -->

            <div class="form-group">

                <label for="full_name">
                    Full Name
                </label>

                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["full_name"]
                        ?? $manager["full_name"]
                    ) ?>"
                >

            </div>

            <!-- Username -->

            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["username"]
                        ?? $manager["username"]
                    ) ?>"
                >

            </div>

            <!-- Phone -->

            <div class="form-group">

                <label for="phone">
                    Phone
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["phone"]
                        ?? $manager["phone"]
                    ) ?>"
                >

            </div>

            <!-- Email -->

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    value="<?= htmlspecialchars(
                        $_POST["email"]
                        ?? $manager["email"]
                    ) ?>"
                >

            </div>

            <!-- Status -->

            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    name="status"
                    id="status"
                    required
                >

                    <option
                        value="active"
                        <?= (
                            ($_POST["status"] ?? $manager["status"])
                            === "active"
                        ) ? "selected" : "" ?>
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        <?= (
                            ($_POST["status"] ?? $manager["status"])
                            === "inactive"
                        ) ? "selected" : "" ?>
                    >
                        Inactive
                    </option>

                </select>

            </div>

            <!-- Profile Image -->

            <div class="form-group">

                <label for="image">
                    Profile Image
                </label>

                <?php if (!empty($manager["image"])): ?>

                    <div style="margin-bottom: 10px;">

                        <img
                            src="/PulseFit/uploads/users/<?= htmlspecialchars($manager["image"]) ?>"
                            alt="Current Profile Photo"
                            style="
                                width: 80px;
                                height: 80px;
                                object-fit: cover;
                                border-radius: 50%;
                            "
                        >

                    </div>

                <?php endif; ?>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    Optional. Leave empty to keep the current image.
                </small>

            </div>

            <!-- Submit -->

            <button
                type="submit"
                class="form-button"
            >
                Update Manager
            </button>

            <!-- Back -->

            <div>

                <a
                    href="managers.php"
                    class="back-link"
                >
                    Back to Managers
                </a>

            </div>

        </form>

    </div>

</div>

</body>

</html>