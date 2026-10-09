<?php

require_once __DIR__ . "/../../../classes/user.php";

$user = new User();

$managers = $user->getManagers();

$managerRecord = null;


if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["user_id"])
) {

    $user_id = trim($_POST["user_id"]);


    if (is_numeric($user_id)) {

        $managerRecord = $user->getById($user_id);


        // Make sure the selected user is actually a Manager

        if (
            $managerRecord
            && $managerRecord["profile_id"] != 2
        ) {

            $managerRecord = null;

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

    <title>Managers - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../../assets/css/style.css"
    >

</head>


<body>


<div class="main-content">


    <!-- =========================
         Page Header
    ========================= -->

    <div class="dashboard-header">

        <div>

            <h1>
                Managers
            </h1>

            <p>
                Manage PulseFit managers
            </p>

        </div>

    </div>


    <!-- =========================
         Add Manager
    ========================= -->

    <div style="margin-bottom: 20px;">

        <a
            href="add_manager.php"
            class="form-button"
        >
            Add Manager
        </a>

    </div>


    <!-- =========================
         Managers Table
    ========================= -->

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


        <?php if (empty($managers)): ?>

            <tr>

                <td colspan="8">
                    No managers found.
                </td>

            </tr>

        <?php else: ?>


            <?php foreach ($managers as $item): ?>

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
                                alt="Manager Photo"
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
                                href="edit_manager.php?id=<?= $item["user_id"] ?>"
                                class="edit-button"
                            >
                                Edit
                            </a>


                            <a
                                href="delete_manager.php?id=<?= $item["user_id"] ?>"
                                class="delete-button"
                                onclick="return confirm('Are you sure you want to delete this manager?');"
                            >
                                Delete
                            </a>

                        </div>

                    </td>


                </tr>

            <?php endforeach; ?>


        <?php endif; ?>

    </table>


    <!-- =========================
         Get Manager By ID
    ========================= -->

    <div
        class="form-container"
        style="margin-top: 50px;"
    >

        <h2>
            Get Manager By ID
        </h2>


        <form method="POST">


            <div class="form-group">

                <label for="user_id">
                    Manager ID
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
                Get Manager
            </button>


        </form>

    </div>


    <!-- =========================
         Manager Record
    ========================= -->

    <?php if ($managerRecord): ?>


        <div
            class="record-container"
            style="margin-top: 30px;"
        >


            <h2>
                Manager Record
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


                    <!-- ID -->

                    <td>

                        <?= htmlspecialchars(
                            $managerRecord["user_id"]
                        ) ?>

                    </td>


                    <!-- Photo -->

                    <td>

                        <?php if (!empty($managerRecord["image"])): ?>

                            <img
                                src="/PulseFit/uploads/users/<?= htmlspecialchars($managerRecord["image"]) ?>"
                                alt="Manager Photo"
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


                    <!-- Full Name -->

                    <td>

                        <?= htmlspecialchars(
                            $managerRecord["full_name"]
                        ) ?>

                    </td>


                    <!-- Username -->

                    <td>

                        <?= htmlspecialchars(
                            $managerRecord["username"]
                        ) ?>

                    </td>


                    <!-- Phone -->

                    <td>

                        <?= htmlspecialchars(
                            $managerRecord["phone"]
                        ) ?>

                    </td>


                    <!-- Email -->

                    <td>

                        <?= htmlspecialchars(
                            $managerRecord["email"]
                        ) ?>

                    </td>


                    <!-- Status -->

                    <td>

                        <?= htmlspecialchars(
                            $managerRecord["status"]
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
            Manager not found.
        </div>


    <?php endif; ?>


</div>


</body>

</html>