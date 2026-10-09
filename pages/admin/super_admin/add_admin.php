<?php

require_once __DIR__ . "/../../../classes/user.php";
require_once __DIR__ . "/../../../functions/image_helper.php";

$user = new User();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
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
        $password === "" ||
        $phone === "" ||
        $email === "" ||
        $status === ""
    ) {

        if ($image !== null) {
            deleteUserImage($image);
        }

        $message = "Please fill in all fields.";

    } else {

        $result = $user->create(
            $full_name,
            $username,
            $password,
            "Super Admin",
            1,
            $phone,
            $email,
            $status,
            $image
        );


        if ($result) {

            header("Location: admins.php");
            exit;

        }


        if ($image !== null) {
            deleteUserImage($image);
        }

        $message = "Failed to add admin.";

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

    <title>Add Admin - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../../assets/css/style.css"
    >

</head>

<body>

<div class="main-content">

    <div class="dashboard-header">

        <h1>
            Add Admin
        </h1>

        <p>
            Create a new administrator account
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
                        $_POST["full_name"] ?? ""
                    ) ?>"
                >

            </div>


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
                        $_POST["username"] ?? ""
                    ) ?>"
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

            </div>


            <div class="form-group">

                <label for="image">
                    Profile Image
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    Optional. JPG, PNG, or WebP. Maximum 5 MB.
                </small>

            </div>


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
                        $_POST["phone"] ?? ""
                    ) ?>"
                >

            </div>


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
                        $_POST["email"] ?? ""
                    ) ?>"
                >

            </div>


            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    name="status"
                    id="status"
                    required
                >

                    <option value="">
                        Select Status
                    </option>

                    <option
                        value="active"
                        <?= (
                            ($_POST["status"] ?? "") === "active"
                        ) ? "selected" : "" ?>
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        <?= (
                            ($_POST["status"] ?? "") === "inactive"
                        ) ? "selected" : "" ?>
                    >
                        Inactive
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Add Admin
            </button>


            <div>

                <a
                    href="admins.php"
                    class="back-link"
                >
                    Back to Admins
                </a>

            </div>

        </form>

    </div>

</div>

</body>

</html>