<?php

session_start();

$name = "";
$email = "";
$subject = "";
$message = "";

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");

    $errors = [];

    if ($name === "") {
        $errors[] = "Please enter your full name.";
    }

    if ($email === "") {
        $errors[] = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if ($subject === "") {
        $errors[] = "Please enter a subject.";
    }

    if ($message === "") {
        $errors[] = "Please enter your message.";
    }

    if (empty($errors)) {

        $successMessage =
            "Your message has been sent successfully. We will get back to you soon.";

        $name = "";
        $email = "";
        $subject = "";
        $message = "";

    } else {

        $errorMessage = implode(" ", $errors);
    }
}

require_once __DIR__ . "/../includes/header.php";
?>

<main class="public-page contact-page">

    <!-- Page Hero -->

    <section class="page-hero">

        <h1>Contact Us</h1>

        <p>
            Have questions about our training programs' 
            membership plans, or class schedules? Reach out to 
            our team today and let us help you take the first 
            step toward achieving your fitness goals. 
        </p>

    </section>


    <!-- Contact Section -->

    <section class="contact-section">

        <div class="contact-grid">


            <!-- Contact Information -->

            <div class="contact-info">

                <span class="contact-label">
                    GET IN TOUCH
                </span>

                <h2>
                    Let's Talk About Your Fitness Journey
                </h2>

                <p class="contact-intro">
                    Whether you have a question about memberships, classes,
                    trainers, or anything else, feel free to contact us.
                </p>


                <div class="contact-details">

                    <div class="contact-detail">

                        <div class="contact-detail-icon">
                            📍
                        </div>

                        <div>
                            <h3>
                                Location
                            </h3>

                            <p>
                                Sana'a, Yemen
                            </p>
                        </div>

                    </div>


                    <div class="contact-detail">

                        <div class="contact-detail-icon">
                            📞
                        </div>

                        <div>
                            <h3>
                                Phone
                            </h3>

                            <p>
                                +967 777 888 666
                            </p>
                        </div>

                    </div>


                    <div class="contact-detail">

                        <div class="contact-detail-icon">
                            ✉
                        </div>

                        <div>
                            <h3>
                                Email
                            </h3>

                            <p>
                                info@pulsefit.com
                            </p>
                        </div>

                    </div>


                    <div class="contact-detail">

                        <div class="contact-detail-icon">
                            🕒
                        </div>

                        <div>
                            <h3>
                                Opening Hours
                            </h3>

                            <p>
                                Saturday - Thursday
                            </p>

                            <p>
                                6:00 AM - 10:00 PM
                            </p>
                        </div>

                    </div>

                </div>

            </div>
            
            <br> <br> <br> <br> <br>

            <!-- Contact Form -->

            <div class="contact-form-card">

                <h2>
                    Send Us a Message
                </h2>

                <p class="form-intro">
                    Fill in the form below and our team will get back to you.
                </p>


                <?php if ($successMessage !== ""): ?>

                    <div
                        class="contact-message contact-success"
                        role="status"
                    >

                        <span>
                            ✓
                        </span>

                        <p>
                            <?= htmlspecialchars($successMessage) ?>
                        </p>

                    </div>

                <?php endif; ?>


                <?php if ($errorMessage !== ""): ?>

                    <div
                        class="contact-message contact-error"
                        role="alert"
                    >

                        <span>
                            ⚠
                        </span>

                        <p>
                            <?= htmlspecialchars($errorMessage) ?>
                        </p>

                    </div>

                <?php endif; ?>


                <form
                    method="POST"
                    action=""
                    id="contactForm"
                    novalidate
                >

                    <!-- Name -->

                    <div class="form-group">

                        <label for="name">

                            Full Name

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?= htmlspecialchars($name) ?>"
                            placeholder="Enter your full name"
                            autocomplete="name"
                            required
                        >

                        <small class="field-help">
                            Please enter your first and last name.
                        </small>

                    </div>


                    <!-- Email -->

                    <div class="form-group">

                        <label for="email">

                            Email Address

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($email) ?>"
                            placeholder="Enter your email address"
                            autocomplete="email"
                            required
                        >

                        <small class="field-help">
                            We will use this email to reply to you.
                        </small>

                    </div>


                    <!-- Subject -->

                    <div class="form-group">

                        <label for="subject">

                            Subject

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            value="<?= htmlspecialchars($subject) ?>"
                            placeholder="What is your message about?"
                            required
                        >

                    </div>


                    <!-- Message -->

                    <div class="form-group">

                        <label for="message">

                            Message

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            placeholder="Write your message here..."
                            required
                        ><?= htmlspecialchars($message) ?></textarea>

                        <small class="field-help">
                            Please provide enough details so we can help you.
                        </small>

                    </div>


                    <!-- Submit -->

                    <button
                        type="submit"
                        class="form-button contact-submit"
                    >
                        Send Message
                    </button>


                    <p class="required-note">
                        <span class="required-mark">
                            *
                        </span>

                        Required fields
                    </p>

                </form>

            </div>

        </div>

    </section>


    <!-- FAQ / Help -->

    <section class="contact-help">

        <div class="contact-help-content">

            <span class="contact-label">
                NEED HELP?
            </span>

            <h2>
                Can't Find What You're Looking For?
            </h2>

            <p>
                Our team is ready to answer your questions and help you choose
                the right fitness option.
            </p>

            <a
                href="memberships.php"
                class="contact-help-button"
            >
                Explore Memberships
            </a>

        </div>

    </section>

</main>


<script>

const contactForm = document.getElementById("contactForm");

contactForm.addEventListener("submit", function (event) {

    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const subject = document.getElementById("subject");
    const message = document.getElementById("message");

    let isValid = true;

    [name, email, subject, message].forEach(field => {

        field.classList.remove("input-error");

    });


    if (name.value.trim() === "") {

        name.classList.add("input-error");
        isValid = false;

    }


    if (
        email.value.trim() === "" ||
        !email.validity.valid
    ) {

        email.classList.add("input-error");
        isValid = false;

    }


    if (subject.value.trim() === "") {

        subject.classList.add("input-error");
        isValid = false;

    }


    if (message.value.trim() === "") {

        message.classList.add("input-error");
        isValid = false;

    }


    if (!isValid) {

        event.preventDefault();

        const firstError =
            document.querySelector(".input-error");

        if (firstError) {
            firstError.focus();
        }
    }

});

</script>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>