<?php

require_once __DIR__ . "/../../classes/membership.php";

$membership = new Membership();

$memberships = $membership->getAllMemberships();

$membershipRecord = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["membership_id"])) {

    $membership_id = trim($_POST["membership_id"]);

    if (is_numeric($membership_id)) {
        $membershipRecord = $membership->getMembershipById($membership_id);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Memberships - PulseFit</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

    <div class="main-content">

        <div class="dashboard-header">

            <h1>Memberships</h1>

            <p>Manage gym membership plans</p>

        </div>


        <a href="add_membership.php">
            Add Membership
        </a>


        <table>

            <tr>

                <th>ID</th>

                <th>Name</th>

                <th>Duration</th>

                <th>Price</th>

                <th>Description</th>

                <th>Actions</th>

            </tr>


            <?php foreach ($memberships as $item): ?>

                <tr>

                    <td>
                        <?= $item["membership_id"] ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $item["membership_name"]
                        ) ?>
                    </td>


                    <td>
                        <?= $item["duration"] ?> days
                    </td>


                    <td>
                        <?= $item["price"] ?>
                    </td>


                    <td>
                        <?= htmlspecialchars(
                            $item["description"]
                        ) ?>
                    </td>

                    <td>

<div class="table-actions">

    <a
        href="edit_membership.php?id=<?= $item["membership_id"] ?>"
        class="edit-button"
    >
        Edit
    </a>


    <a
        href="delete_membership.php?id=<?= $item["membership_id"] ?>"
        class="delete-button"
        onclick="return confirm('Are you sure you want to delete this membership?');"
    >
        Delete
    </a>

</div>

</td>

                </tr>

            <?php endforeach; ?>

        </table>


        <!-- Get Membership By ID -->

<div class="form-container">

<h2>Get Membership By ID</h2>

<form method="POST">

    <div class="form-group">

        <label for="membership_id">
            Membership ID
        </label>

        <input
            type="number"
            id="membership_id"
            name="membership_id"
            min="1"
            required
        >

    </div>

    <button type="submit">
        Get Membership
    </button>

</form>

</div>


<?php if ($membershipRecord): ?>

<div class="record-container">

<h2>Membership Record</h2>

<table>

    <tr>

        <th>ID</th>
        <th>Membership Name</th>
        <th>Duration</th>
        <th>Price</th>
        <th>Description</th>

    </tr>

    <tr>

        <td>
            <?= $membershipRecord["membership_id"] ?>
        </td>

        <td>
            <?= htmlspecialchars($membershipRecord["membership_name"]) ?>
        </td>

        <td>
            <?= htmlspecialchars($membershipRecord["duration"]) ?>
        </td>

        <td>
            <?= htmlspecialchars($membershipRecord["price"]) ?>
        </td>

        <td>
            <?= htmlspecialchars($membershipRecord["description"]) ?>
        </td>

    </tr>

</table>

</div>

<?php endif; ?>

</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>