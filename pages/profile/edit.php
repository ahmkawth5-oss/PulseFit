<?php

require_once __DIR__ . "/../../functions/helpers.php";
requireLogin();

require_once __DIR__ . "/../../config/database.php";

$userId = $_SESSION['user_id'];

$message = "";
$error = "";

$stmt = $conn->prepare("
    SELECT full_name, username, email, phone, image
    FROM users
    WHERE user_id = ?
");

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

if (!$user) {
    header("Location: " . baseUrl() . "/auth/login.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullName = trim($_POST["full_name"]);

    if ($fullName === "") {

        $error = "Full name is required.";

    } else {

        $imageName = $user["image"];


        // =========================
        // Upload Profile Image
        // =========================

        if (
            isset($_FILES["image"]) &&
            $_FILES["image"]["error"] === UPLOAD_ERR_OK
        ) {

            $uploadDir = __DIR__ . "/../../uploads/users/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }


            $allowedTypes = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];

            $fileType = mime_content_type(
                $_FILES["image"]["tmp_name"]
            );


            if (!in_array($fileType, $allowedTypes, true)) {

                $error = "Only JPG, PNG and WEBP images are allowed.";

            } else {

                $extension = strtolower(
                    pathinfo(
                        $_FILES["image"]["name"],
                        PATHINFO_EXTENSION
                    )
                );


                $newFileName =
                    "user_" .
                    $userId .
                    "_" .
                    time() .
                    "." .
                    $extension;


                $destination = $uploadDir . $newFileName;


                if (
                    move_uploaded_file(
                        $_FILES["image"]["tmp_name"],
                        $destination
                    )
                ) {

                    // Delete old profile image

                    if (!empty($user["image"])) {

                        $oldImage =
                            $uploadDir .
                            $user["image"];

                        if (
                            is_file($oldImage) &&
                            $user["image"] !== $newFileName
                        ) {

                            unlink($oldImage);
                        }
                    }


                    $imageName = $newFileName;

                } else {

                    $error = "Failed to upload the image.";
                }
            }
        }


        // =========================
        // Update User
        // =========================

        if ($error === "") {

            $stmt = $conn->prepare("
                UPDATE users
                SET full_name = ?, image = ?
                WHERE user_id = ?
            ");

            $stmt->bind_param(
                "ssi",
                $fullName,
                $imageName,
                $userId
            );


            if ($stmt->execute()) {

                $_SESSION["full_name"] = $fullName;
                $_SESSION["profile_image"] = $imageName;


                header(
                    "Location: " .
                    baseUrl() .
                    "/pages/profile/edit.php?success=1"
                );

                exit;

            } else {

                $error = "Failed to update profile.";
            }


            $stmt->close();
        }
    }
}


if (isset($_GET["success"])) {

    $message = "Profile updated successfully.";
}

?>


<?php require_once __DIR__ . "/../../includes/header.php"; ?>


<div class="form-container profile-edit">

    <h1>Edit Profile</h1>


    <?php if ($message): ?>

        <div class="success-message">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>


    <?php if ($error): ?>

        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <form
        method="POST"
        enctype="multipart/form-data"
    >


        <!-- Profile Image -->

        <div class="profile-image-section">

            <?php if (!empty($user["image"])): ?>

                <img
                    src="<?= baseUrl() ?>/uploads/users/<?= htmlspecialchars($user["image"]) ?>"
                    class="edit-profile-image"
                    alt="Profile Image"
                >

            <?php else: ?>

                <div class="profile-placeholder">

                    <?= strtoupper(
                        substr(
                            $user["full_name"],
                            0,
                            1
                        )
                    ) ?>

                </div>

            <?php endif; ?>


            <label for="image">
                Change Photo
            </label>


            <input
                type="file"
                name="image"
                id="image"
                accept="image/jpeg,image/png,image/webp"
            >

        </div>


        <!-- Full Name -->

        <div class="form-group">

            <label for="full_name">
                Full Name
            </label>


            <input
                type="text"
                name="full_name"
                id="full_name"
                value="<?= htmlspecialchars($user["full_name"]) ?>"
                required
            >

        </div>


        <!-- Username -->

        <div class="form-group">

            <label>
                Username
            </label>


            <input
                type="text"
                value="<?= htmlspecialchars($user["username"]) ?>"
                disabled
            >

        </div>


        <!-- Buttons -->

        <div class="form-actions">

            <button
                type="submit"
                class="btn-primary"
            >
                Save Changes
            </button>


            <a
                href="javascript:history.back()"
                class="btn-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>


<?php require_once __DIR__ . "/../../includes/footer.php"; ?>
