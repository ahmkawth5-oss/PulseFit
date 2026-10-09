<?php

require_once __DIR__ . "/../../classes/membership.php";

$membership = new Membership();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: memberships.php");
    exit;
}

$membership_id = $_GET["id"];

$data = $membership->getMembershipById($membership_id);

if (!$data) {
    header("Location: memberships.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $membership_name = trim($_POST["membership_name"]);
    $duration = $_POST["duration"];
    $price = $_POST["price"];
    $description = trim($_POST["description"]);

    if (
        $membership_name === "" ||
        $duration === "" ||
        $price === ""
    ) {
        $message = "Please fill in all required fields.";
    } else {

        $result = $membership->updateMembership(
            $membership_id,
            $membership_name,
            $duration,
            $price,
            $description
        );

        if ($result !== false) {
            header("Location: memberships.php");
            exit;
        }

        $message = "Failed to update membership.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Membership - PulseFit</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

    <div class="main-content">

        <div class="dashboard-header">

            <h1>Edit Membership</h1>

            <p>Update gym membership plan</p>

        </div>


        <?php if ($message !== ""): ?>

            <div class="auth-message">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>


        <div class="form-container">

            <form method="POST">

                <div class="form-group">

                    <label for="membership_name">
                        Membership Name
                    </label>

                    <input
                        type="text"
                        id="membership_name"
                        name="membership_name"
                        required
                        value="<?= htmlspecialchars(
                            $_POST["membership_name"]
                            ?? $data["membership_name"]
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="duration">
                        Duration
                    </label>

                    <input
                        type="number"
                        id="duration"
                        name="duration"
                        min="1"
                        required
                        value="<?= htmlspecialchars(
                            $_POST["duration"]
                            ?? $data["duration"]
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="price">
                        Price
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        min="0"
                        step="0.01"
                        required
                        value="<?= htmlspecialchars(
                            $_POST["price"]
                            ?? $data["price"]
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                    ><?= htmlspecialchars(
                        $_POST["description"]
                        ?? $data["description"]
                    ) ?></textarea>

                </div>


                <button
                    type="submit"
                    class="form-button"
                >
                    Update Membership
                </button>

                <div>
                <a
                    href="memberships.php"
                    class="back-link"
                >
                    Back to Memberships
                </a>
                </div>

            </form>

        </div>
</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>