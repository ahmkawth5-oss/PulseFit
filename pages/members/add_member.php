<?php

require_once __DIR__ . "/../../functions/helpers.php";
requirePermission("manage_members");

require_once __DIR__ . "/../../classes/member.php";
require_once __DIR__ . "/../../functions/image_helper.php";

$member = new Member();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $gender = $_POST["gender"];
    $birth_date = $_POST["birth_date"];
    $join_date = $_POST["join_date"];

    if (
        $full_name === "" ||
        $username === "" ||
        $password === "" ||
        $gender === "" ||
        $birth_date === "" ||
        $join_date === ""
    ) {

        $message = "Please fill in all required fields.";

    } else {

        $image = uploadUserImage($_FILES["image"] ?? null);

        if ($image === false) {

            $message = "Please upload a valid JPG, PNG, or WebP image up to 5 MB.";

        } else {

            $result = $member->createMember(
                $full_name,
                $username,
                $password,
                $phone,
                $email,
                "active",
                $gender,
                $birth_date,
                $join_date,
                $image
            );

            if ($result) {

                header("Location: members.php");
                exit;

            }

            if ($image !== null) {
                deleteUserImage($image);
            }

            $message = "Failed to add member.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Member - PulseFit</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

    <div class="main-content">

        <div class="dashboard-header">

            <h1>Add Member</h1>

            <p>Create a new gym member</p>

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
                        value="<?= htmlspecialchars($_POST["full_name"] ?? "") ?>"
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
                        value="<?= htmlspecialchars($_POST["username"] ?? "") ?>"
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

                    <label for="phone">
                        Phone
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="<?= htmlspecialchars($_POST["phone"] ?? "") ?>"
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
                        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                    >

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

                        <option value="Male">
                            Male
                        </option>

                        <option value="Female">
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
                        value="<?= htmlspecialchars($_POST["birth_date"] ?? "") ?>"
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
                            $_POST["join_date"] ?? date("Y-m-d")
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="image">
                        Profile Image (optional)
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <small>
                        JPG, PNG or WebP. Maximum 5 MB.
                    </small>

                </div>


                <button
                    type="submit"
                    class="form-button"
                >
                    Add Member
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