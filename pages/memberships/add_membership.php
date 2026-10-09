<?php

require_once __DIR__ . "/../../classes/membership.php";

$membership = new Membership();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $membership->createMembership(
        $_POST["membership_name"],
        $_POST["duration"],
        $_POST["price"],
        $_POST["description"]
    );

    header("Location: memberships.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Membership - PulseFit</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

    <div class="main-content">

        <div class="dashboard-header">

            <h1>Add Membership</h1>

            <p>Create a new gym membership plan</p>

        </div>


        <div class="form-container">

            <form method="POST">

                <div class="form-group">

                    <label>
                        Membership Name
                    </label>

                    <input
                        type="text"
                        name="membership_name"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Duration
                    </label>

                    <input
                        type="number"
                        name="duration"
                        min="1"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Price
                    </label>

                    <input
                        type="number"
                        name="price"
                        step="0.01"
                        min="0"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                    ></textarea>

                </div>


                <button
                    type="submit"
                    class="form-button"
                >
                    Add Membership
                </button>

                <br>

                <a
                    href="memberships.php"
                    class="back-link"
                >
                    Back to Memberships
                </a>

            </form>

        </div>

</div>


<script src="../../assets/js/theme.js"></script>

</body>

</html>