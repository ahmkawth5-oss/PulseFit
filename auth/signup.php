<?php

session_start();

require_once __DIR__ . "/../classes/member.php";

$member = new Member();

$message = "";


// =========================
// Redirect logged-in users
// =========================

if (isset($_SESSION["user_id"])) {

    header("Location: ../index.php");
    exit;
}


// =========================
// Signup
// =========================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $gender = trim($_POST["gender"] ?? "");
    $birth_date = $_POST["birth_date"] ?? "";
    $join_date = $_POST["join_date"] ?? date("Y-m-d");


    if (
        $full_name === "" ||
        $username === "" ||
        $password === "" ||
        $phone === "" ||
        $email === "" ||
        $gender === "" ||
        $birth_date === ""
    ) {

        $message = "Please fill in all required fields.";

    } elseif (strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";

    } elseif ($member->getByUsername($username)) {

        $message = "Username already exists.";

    } elseif ($member->getByEmail($email)) {

        $message = "Email already exists.";

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
            $join_date
        );


        if ($result) {

            header("Location: login.php");
            exit;

        }


        $message = "Failed to create account.";
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

    <title>Sign Up - PulseFit</title>

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

</head>

<body class="auth-page">

<div class="form-container">

    <div class="dashboard-header">

        <h1>
            PulseFit
        </h1>

        <p>
            Create your member account
        </p>

    </div>


    <?php if ($message !== ""): ?>

        <div class="auth-message">

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>


    <form method="POST">

        <div class="form-group">

            <label for="full_name">
                Full Name
            </label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="<?= htmlspecialchars($_POST["full_name"] ?? "") ?>"
                required
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
                value="<?= htmlspecialchars($_POST["username"] ?? "") ?>"
                required
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
                required
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
                required
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

                <option
                    value="Male"
                    <?= (($_POST["gender"] ?? "") === "Male")
                        ? "selected"
                        : "" ?>
                >
                    Male
                </option>

                <option
                    value="Female"
                    <?= (($_POST["gender"] ?? "") === "Female")
                        ? "selected"
                        : "" ?>
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
                value="<?= htmlspecialchars($_POST["birth_date"] ?? "") ?>"
                required
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
                value="<?= htmlspecialchars(
                    $_POST["join_date"] ?? date("Y-m-d")
                ) ?>"
                required
            >

        </div>


        <button
            type="submit"
            class="form-button"
        >
            Create Account
        </button>


    </form>


    <p>

        Already have an account?

        <a href="login.php">
            Login
        </a>

    </p>

</div>


<script src="../assets/js/theme.js"></script>

</body>

</html>