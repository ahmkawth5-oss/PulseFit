<?php

session_start();

require_once __DIR__ . "/../classes/user.php";

$userModel = new User();

$message = "";


// ==========================================
// Redirect logged-in users
// ==========================================

if (
    isset($_SESSION["user_id"]) &&
    isset($_SESSION["profile_id"])
) {

    if ($_SESSION["profile_id"] == 1) {

        header(
            "Location: ../pages/admin/super_admin/dashboard.php"
        );

    } elseif ($_SESSION["profile_id"] == 2) {

        header(
            "Location: ../pages/admin/managers/dashboard.php"
        );

    } elseif ($_SESSION["profile_id"] == 3) {

        header(
            "Location: ../pages/trainers/dashboard.php"
        );

    } elseif ($_SESSION["profile_id"] == 4) {

        header(
            "Location: ../pages/members/dashboard.php"
        );
    } else {
        $message = "Invalid user profile.";
    }

    exit;
}


// ==========================================
// Login
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";


    // ==========================================
    // Check empty fields
    // ==========================================

    if ($username === "" || $password === "") {

        $message = "Please enter username and password.";

    } else {

        // ==========================================
        // Get user
        // ==========================================

        $user = $userModel->getByUsername($username);

        if ($user) {

            // ==========================================
            // Check password
            // ==========================================

            if (password_verify($password, $user["password"])) {

                // ==========================================
                // Check account status
                // ==========================================

                if (
                    strtolower($user["status"]) !== "active"
                ) {

                    $message = "Your account is not active.";

                } else {

                    // ==========================================
                    // Store user information in session
                    // ==========================================

                    $_SESSION["user_id"] =
                        $user["user_id"];

                    $_SESSION["username"] =
                        $user["username"];

                    $_SESSION["role"] =
                        $user["role"];

                    $_SESSION["profile_id"] =
                        $user["profile_id"];


                    // ==========================================
                    // Redirect according to profile
                    // ==========================================

                    if ($user["profile_id"] == 1) {

                        header(
                            "Location: ../pages/admin/super_admin/dashboard.php"
                        );

                    } elseif ($user["profile_id"] == 2) {

                        header(
                            "Location: ../pages/admin/managers/dashboard.php"
                        );

                    } elseif ($user["profile_id"] == 3) {

                        header(
                            "Location: ../pages/trainers/dashboard.php"
                        );

                    } elseif ($user["profile_id"] == 4) {

                        header(
                            "Location: ../pages/members/dashboard.php"
                        );

                    } else {

                        $message = "Invalid user profile.";

                        // Remove session if profile is invalid
                        session_unset();
                    }

                    exit;
                }

            } else {

                $message = "Incorrect password.";

            }

        } else {

            $message = "Username not found.";

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

    <title>Login - PulseFit</title>

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

</head>


<body>


<div class="auth-container">

    <div class="auth-box">

        <h1>
            PulseFit
        </h1>

        <h2>
            Login
        </h2>


        <?php if ($message !== ""): ?>

            <div class="auth-message">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <form method="POST">


            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?= htmlspecialchars(
                        $_POST["username"] ?? ""
                    ) ?>"
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


            <button
                type="submit"
                class="form-button"
            >
                Login
            </button>


        </form>


        <p>

            Don't have an account?

            <a href="signup.php">
                Sign Up
            </a>

        </p>


    </div>

</div>


<script src="../assets/js/theme.js"></script>

</body>

</html>