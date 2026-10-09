<?php

require_once __DIR__ . "/../../functions/helpers.php";
requirePermission("manage_members");

require_once __DIR__ . "/../../classes/member.php";

$member = new Member();

$members = $member->getAll();

$selectedMember = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["view_id"])) {

    $view_id = trim($_POST["view_id"]);

    if (is_numeric($view_id)) {
        $selectedMember = $member->getById($view_id);
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

    <title>Members - PulseFit</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>


<div class="main-content">


    <!-- =========================
         Page Header
    ========================= -->

    <header class="dashboard-header">

        <h1>
            Members
        </h1>

        <p>
            Manage gym members
        </p>

    </header>


    <!-- =========================
         Add Member
    ========================= -->

    <a href="add_member.php">
        Add Member
    </a>


    <!-- =========================
         Members Table
    ========================= -->

    <table>

        <tr>

            <th>ID</th>

            <th>Photo</th>

            <th>Full Name</th>

            <th>Username</th>

            <th>Phone</th>

            <th>Email</th>

            <th>Gender</th>

            <th>Birth Date</th>

            <th>Join Date</th>

            <th>Actions</th>

        </tr>


        <?php foreach ($members as $item): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($item["member_id"]) ?>
                </td>


                <td>

                    <?php if (!empty($item["image"])): ?>

                        <img
                            src="/PulseFit/uploads/users/<?= htmlspecialchars($item["image"]) ?>"
                            alt="Member Photo"
                            style="
                                width: 50px;
                                height: 50px;
                                object-fit: cover;
                                border-radius: 50%;
                            "
                        >

                    <?php else: ?>

                        <span>
                            No Photo
                        </span>

                    <?php endif; ?>

                </td>


                <td>
                    <?= htmlspecialchars($item["full_name"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["username"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["phone"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["email"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["gender"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["birth_date"]) ?>
                </td>


                <td>
                    <?= htmlspecialchars($item["join_date"]) ?>
                </td>


                <td>

                    <div class="table-actions">

                        <a
                            href="edit_member.php?id=<?= $item["member_id"] ?>"
                            class="edit-button"
                        >
                            Edit
                        </a>

                        <a
                            href="delete_member.php?id=<?= $item["member_id"] ?>"
                            class="delete-button"
                            onclick="return confirm('Are you sure you want to delete this member?');"
                        >
                            Delete
                        </a>

                    </div>

                </td>

            </tr>

        <?php endforeach; ?>


    </table>


    <!-- =========================
         Get Member By ID
    ========================= -->

    <div class="form-container">

        <h2>
            Get Member By ID
        </h2>


        <form method="POST">

            <div class="form-group">

                <label for="view_id">
                    Member ID
                </label>

                <input
                    type="number"
                    id="view_id"
                    name="view_id"
                    min="1"
                    required
                >

            </div>


            <button
                type="submit"
                class="form-button"
            >
                Get Member
            </button>

        </form>

    </div>


    <!-- =========================
         Selected Member
    ========================= -->

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["view_id"])): ?>


        <?php if ($selectedMember): ?>


            <div class="record-container">

                <h2>
                    Member Record
                </h2>


                <table>

                    <tr>

                        <th>ID</th>

                        <th>Photo</th>

                        <th>Full Name</th>

                        <th>Username</th>

                        <th>Phone</th>

                        <th>Email</th>

                        <th>Gender</th>

                        <th>Birth Date</th>

                        <th>Join Date</th>

                        <th>Status</th>

                    </tr>


                    <tr>

                        <td>
                            <?= htmlspecialchars($selectedMember["member_id"]) ?>
                        </td>


                        <td>

                            <?php if (!empty($selectedMember["image"])): ?>

                                <img
                                    src="/PulseFit/uploads/users/<?= htmlspecialchars($selectedMember["image"]) ?>"
                                    alt="Member Photo"
                                    style="
                                        width: 70px;
                                        height: 70px;
                                        object-fit: cover;
                                        border-radius: 50%;
                                    "
                                >

                            <?php else: ?>

                                <span>
                                    No Photo
                                </span>

                            <?php endif; ?>

                        </td>


                        <td>
                            <?= htmlspecialchars($selectedMember["full_name"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($selectedMember["username"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($selectedMember["phone"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($selectedMember["email"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($selectedMember["gender"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($selectedMember["birth_date"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($selectedMember["join_date"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($selectedMember["status"]) ?>
                        </td>

                    </tr>

                </table>

            </div>


        <?php else: ?>


            <div class="auth-message">

                Member not found.

            </div>


        <?php endif; ?>


    <?php endif; ?>


</div>

</body>

</html>