<?php

require_once __DIR__ . "/../../../classes/user.php";

$user = new User();

$admins = $user->getAdmins();

$adminRecord = null;

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["user_id"])
) {

    $user_id = trim($_POST["user_id"]);

    if (is_numeric($user_id)) {

        $adminRecord = $user->getById($user_id);

        // Make sure the selected user is actually an Admin

        if (
            $adminRecord
            && $adminRecord["profile_id"] != 1
        ) {

            $adminRecord = null;

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

    <title>Admins - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../../assets/css/style.css"
    >

</head>

<body>

<div class="main-content">

    <div class="dashboard-header">

        <div>

            <h1>
                Admins
            </h1>

            <p>
                Manage PulseFit administrators
            </p>

        </div>

    </div>


    <!-- Add Admin -->

    <div style="margin-bottom: 20px;">

        <a
            href="add_admin.php"
            class="form-button"
        >
            Add Admin
        </a>

    </div>


    <!-- Admins Table -->

    <table>

        <tr>

            <th>
                ID
            </th>

            <th>
                Photo
            </th>

            <th>
                Full Name
            </th>

            <th>
                Username
            </th>

            <th>
                Phone
            </th>

            <th>
                Email
            </th>

            <th>
                Status
            </th>

            <th>
                Actions
            </th>

        </tr>


        <?php if (empty($admins)): ?>

            <tr>

                <td colspan="8">
                    No admins found.
                </td>

            </tr>

        <?php else: ?>


            <?php foreach ($admins as $item): ?>

                <tr>

                    <!-- ID -->

                    <td>

                        <?= htmlspecialchars(
                            $item["user_id"]
                        ) ?>

                    </td>


                    <!-- Photo -->

                    <td>

                        <?php if (!empty($item["image"])): ?>

                            <img
                                src="/PulseFit/uploads/users/<?= htmlspecialchars($item["image"]) ?>"
                                alt="Admin Photo"
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


                    <!-- Full Name -->

                    <td>

                        <?= htmlspecialchars(
                            $item["full_name"]
                        ) ?>

                    </td>


                    <!-- Username -->

                    <td>

                        <?= htmlspecialchars(
                            $item["username"]
                        ) ?>

                    </td>


                    <!-- Phone -->

                    <td>

                        <?= htmlspecialchars(
                            $item["phone"]
                        ) ?>

                    </td>


                    <!-- Email -->

                    <td>

                        <?= htmlspecialchars(
                            $item["email"]
                        ) ?>

                    </td>


                    <!-- Status -->

                    <td>

                        <?= htmlspecialchars(
                            $item["status"]
                        ) ?>

                    </td>


                    <!-- Actions -->

                    <td>

                        <div class="table-actions">

                            <a
                                href="edit_admin.php?id=<?= $item["user_id"] ?>"
                                class="edit-button"
                            >
                                Edit
                            </a>

                            <a
                                href="delete_admin.php?id=<?= $item["user_id"] ?>"
                                class="delete-button"
                                onclick="return confirm('Are you sure you want to delete this admin?');"
                            >
                                Delete
                            </a>

                        </div>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

    </table>


    <!-- Get Admin By ID -->

    <div
        class="form-container"
        style="margin-top: 50px;"
    >

        <h2>
            Get Admin By ID
        </h2>

        <form method="POST">

            <div class="form-group">

                <label for="user_id">
                    Admin ID
                </label>

                <input
                    type="number"
                    id="user_id"
                    name="user_id"
                    min="1"
                    required
                >

            </div>

            <button
                type="submit"
                class="form-button"
            >
                Get Admin
            </button>

        </form>

    </div>


    <!-- Admin Record -->

    <?php if ($adminRecord): ?>

        <div
            class="record-container"
            style="margin-top: 30px;"
        >

            <h2>
                Admin Record
            </h2>

            <table>

                <tr>

                    <th>
                        ID
                    </th>

                    <th>
                        Photo
                    </th>

                    <th>
                        Full Name
                    </th>

                    <th>
                        Username
                    </th>

                    <th>
                        Phone
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Status
                    </th>

                </tr>

                <tr>

                    <td>

                        <?= htmlspecialchars(
                            $adminRecord["user_id"]
                        ) ?>

                    </td>

                    <td>

                        <?php if (!empty($adminRecord["image"])): ?>

                            <img
                                src="/PulseFit/uploads/users/<?= htmlspecialchars($adminRecord["image"]) ?>"
                                alt="Admin Photo"
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

                        <?= htmlspecialchars(
                            $adminRecord["full_name"]
                        ) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars(
                            $adminRecord["username"]
                        ) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars(
                            $adminRecord["phone"]
                        ) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars(
                            $adminRecord["email"]
                        ) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars(
                            $adminRecord["status"]
                        ) ?>

                    </td>

                </tr>

            </table>

        </div>

    <?php elseif (
        $_SERVER["REQUEST_METHOD"] === "POST"
        && isset($_POST["user_id"])
    ): ?>

        <div
            class="auth-message"
            style="margin-top: 30px;"
        >
            Admin not found.
        </div>

    <?php endif; ?>

</div>

</body>

</html>