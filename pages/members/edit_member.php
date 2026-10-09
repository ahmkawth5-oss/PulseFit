<?php

require_once __DIR__ . "/../../functions/helpers.php";
requirePermission("manage_members");

require_once __DIR__ . "/../../classes/member.php";
require_once __DIR__ . "/../../functions/image_helper.php";

$member = new Member();

$message = "";

$member_id = $_GET["id"] ?? null;

if (!$member_id) {
    header("Location: members.php");
    exit;
}

$currentMember = $member->getById($member_id);

if (!$currentMember) {
    header("Location: members.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $status = $_POST["status"];
    $gender = $_POST["gender"];
    $birth_date = $_POST["birth_date"];
    $join_date = $_POST["join_date"];

    if (
        $full_name === "" ||
        $username === "" ||
        $gender === "" ||
        $birth_date === "" ||
        $join_date === ""
    ) {

        $message = "Please fill in all required fields.";

    } else {

        $oldImage = $currentMember["image"] ?? null;

        $image = uploadUserImage($_FILES["image"] ?? null);

        if ($image === false) {

            $message = "Please upload a valid JPG, PNG, or WebP image up to 5 MB.";

        } else {

            $result = $member->updateMember(
                $member_id,
                $full_name,
                $username,
                $phone,
                $email,
                $status,
                $gender,
                $birth_date,
                $join_date,
                $image
            );

            if ($result) {

                if ($image !== null && $oldImage !== null) {
                    deleteUserImage($oldImage);
                }

                header("Location: members.php");
                exit;
            }

            if ($image !== null) {
                deleteUserImage($image);
            }

            $message = "Failed to update member.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Member - PulseFit</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

    <div class="main-content">

        <div class="dashboard-header">

            <h1>Edit Member</h1>

            <p>Update member information</p>

        </div>


        <?php if ($message !== ""): ?>

            <div class="auth-message">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>


        <div class="form-container">

            <form method="POST" enctype="multipart/form-data">

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
                            $_POST["full_name"] ?? $currentMember["full_name"]
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
                            $_POST["username"] ?? $currentMember["username"]
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="phone">
                        Phone
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="<?= htmlspecialchars(
                            $_POST["phone"] ?? $currentMember["phone"]
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
                        value="<?= htmlspecialchars(
                            $_POST["email"] ?? $currentMember["email"]
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                    >

                        <option
                            value="active"
                            <?= (
                                ($_POST["status"] ?? $currentMember["status"]) === "active"
                            ) ? "selected" : "" ?>
                        >
                            Active
                        </option>

                        <option
                            value="inactive"
                            <?= (
                                ($_POST["status"] ?? $currentMember["status"]) === "inactive"
                            ) ? "selected" : "" ?>
                        >
                            Inactive
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="gender">
                        Gender
                    </label>

                    <select
                        id="gender"
                        name="gender"
                        required
                    >

                        <option value="">
                            Select Gender
                        </option>

                        <option
                            value="Male"
                            <?= (
                                ($_POST["gender"] ?? $currentMember["gender"]) === "Male"
                            ) ? "selected" : "" ?>
                        >
                            Male
                        </option>

                        <option
                            value="Female"
                            <?= (
                                ($_POST["gender"] ?? $currentMember["gender"]) === "Female"
                            ) ? "selected" : "" ?>
                        >
                            Female
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="birth_date">
                        Birth Date
                    </label>

                    <input
                        type="date"
                        id="birth_date"
                        name="birth_date"
                        required
                        value="<?= htmlspecialchars(
                            $_POST["birth_date"] ?? $currentMember["birth_date"]
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="join_date">
                        Join Date
                    </label>

                    <input
                        type="date"
                        id="join_date"
                        name="join_date"
                        required
                        value="<?= htmlspecialchars(
                            $_POST["join_date"] ?? $currentMember["join_date"]
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="image">
                        Profile Image (optional)
                    </label>

                    <?php if (!empty($currentMember["image"])): ?>

                        <div style="margin-bottom: 12px;">

                            <img
                                src="/PulseFit/uploads/users/<?= htmlspecialchars($currentMember["image"]) ?>"
                                alt="Current Profile Image"
                                style="
                                    width: 100px;
                                    height: 100px;
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
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <small>
                        Choose a new image only if you want to change the current image.
                        JPG, PNG or WebP. Maximum 5 MB.
                    </small>

                </div>


                <button
                    type="submit"
                    class="form-button"
                >
                    Update Member
                </button>


                <div>

                    <a
                        href="members.php"
                        class="back-link"
                    >
                        Back to Members
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>