<?php

require_once __DIR__ . "/../../../../classes/user.php";

$user = new User();

$users = $user->getAll();

$selectedUser = null;


// =========================
// Get User By ID
// =========================

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"])) {

    $user_id = trim($_POST["user_id"]);

    if (is_numeric($user_id)) {

        $selectedUser = $user->getById($user_id);

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

    <title>Users - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../../../assets/css/style.css"
    >

</head>


<body>

    <div class="main-content">


        <div class="dashboard-header">

            <h1>
                Users
            </h1>

            <p>
                View PulseFit users
            </p>

        </div>


        <!-- =========================
             Users Table
        ========================= -->

        <table>

            <tr>

                <th>
                    ID
                </th>

                <th>
                    Image
                </th>

                <th>
                    Full Name
                </th>

                <th>
                    Username
                </th>

                <th>
                    Role
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


            <?php foreach ($users as $item): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($item["user_id"]) ?>
                    </td>

                    <td>

                        <?php if (!empty($item["image"])): ?>

                            <img
                                src="/PulseFit/uploads/users/<?= htmlspecialchars($item["image"]) ?>"
                                alt="Profile Photo"
                                class="user-table-image"
                            >

                        <?php else: ?>

                            <div class="user-table-avatar">
                                <?= strtoupper(
                                    substr(
                                        $item["full_name"],
                                        0,
                                        1
                                    )
                                ) ?>
                            </div>

                        <?php endif; ?>

                    </td>

                    <td>
                        <?= htmlspecialchars($item["full_name"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["username"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["role"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["phone"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["email"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["status"]) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </table>


        <!-- =========================
             Get User By ID
        ========================= -->

        <div class="form-container">

            <h2>
                Get User By ID
            </h2>


            <form method="POST">

                <div class="form-group">

                    <label for="user_id">
                        User ID
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
                    Get User
                </button>

            </form>

        </div>


        <!-- =========================
             Single User Record
        ========================= -->

        <?php if ($selectedUser): ?>

            <div class="record-container">

                <h2>
                    User Record
                </h2>


                <table>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Image
                        </th>

                        <th>
                            Full Name
                        </th>

                        <th>
                            Username
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Profile ID
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
                                $selectedUser["user_id"]
                            ) ?>
                        </td>

                        <td>

                            <?php if (!empty($selectedUser["image"])): ?>

                                <img
                                    src="/PulseFit/uploads/users/<?= htmlspecialchars($selectedUser["image"]) ?>"
                                    alt="Profile Photo"
                                    class="user-table-image"
                                >

                            <?php else: ?>

                                <div class="user-table-avatar">
                                    <?= strtoupper(
                                        substr(
                                            $selectedUser["full_name"],
                                            0,
                                            1
                                        )
                                    ) ?>
                                </div>

                            <?php endif; ?>

                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $selectedUser["full_name"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $selectedUser["username"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $selectedUser["role"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $selectedUser["profile_id"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $selectedUser["phone"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $selectedUser["email"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $selectedUser["status"]
                            ) ?>
                        </td>

                    </tr>

                </table>

            </div>


        <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>

            <div class="auth-message">

                User not found.

            </div>

        <?php endif; ?>

    </div>


    <script src="../../../../assets/js/theme.js"></script>

</body>

</html>