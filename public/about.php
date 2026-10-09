<?php

session_start();

require_once __DIR__ . "/../includes/header.php";
?>

<main class="public-page about-page">

    <!-- Page Hero -->

    <section class="page-hero">

        <h1>About PulseFit</h1>

        <p>
            Discover a fitness environment built to help you become stronger,
            healthier, and more confident.
        </p>

    </section>


    <!-- Who We Are -->

    <section class="about-section about-intro">

        <div class="about-content">

            <span class="about-label">
                WHO WE ARE
            </span>

            <h2>
                More Than Just a Gym
            </h2>

            <p>
                PulseFit is a modern fitness center designed for people who
                want to improve their health, strength, and overall lifestyle.
            </p>

            <p>
                We provide a supportive training environment with quality
                equipment, professional trainers, flexible membership plans,
                and a welcoming fitness community.
            </p>

        </div>

        <div class="about-highlight">

            <div class="about-highlight-item">

                <strong>01</strong>

                <div>
                    <h3>Train</h3>
                    <p>
                        Access quality equipment and training spaces.
                    </p>
                </div>

            </div>


            <div class="about-highlight-item">

                <strong>02</strong>

                <div>
                    <h3>Improve</h3>
                    <p>
                        Build strength, endurance, and healthier habits.
                    </p>
                </div>

            </div>


            <div class="about-highlight-item">

                <strong>03</strong>

                <div>
                    <h3>Achieve</h3>
                    <p>
                        Stay consistent and reach your fitness goals.
                    </p>
                </div>

            </div>

        </div>

    </section>


    <!-- Mission -->

    <section class="about-section about-mission">

        <div class="about-mission-card">

            <span class="about-label">
                OUR MISSION
            </span>

            <h2>
                Helping You Build a Better You
            </h2>

            <p>
                Our mission is to make fitness accessible, motivating, and
                enjoyable for everyone. We aim to create an environment where
                every member can train with confidence and make meaningful
                progress.
            </p>

        </div>

    </section>


    <!-- Why Choose PulseFit -->

    <section class="about-section about-why">

        <div class="about-section-heading">

            <span class="about-label">
                WHY PULSEFIT
            </span>

            <h2>
                Everything You Need to Keep Moving
            </h2>

            <p>
                We focus on the essentials that make your fitness journey
                easier and more effective.
            </p>

        </div>


        <div class="about-features">

            <article class="about-feature-card">

                <div class="about-feature-number">
                    01
                </div>

                <h3>
                    Quality Equipment
                </h3>

                <p>
                    Train with a variety of equipment suitable for strength,
                    cardio, and general fitness.
                </p>

            </article>


            <article class="about-feature-card">

                <div class="about-feature-number">
                    02
                </div>

                <h3>
                    Professional Trainers
                </h3>

                <p>
                    Get guidance and support from trainers who can help you
                    improve your training experience.
                </p>

            </article>


            <article class="about-feature-card">

                <div class="about-feature-number">
                    03
                </div>

                <h3>
                    Flexible Memberships
                </h3>

                <p>
                    Choose a membership plan that fits your goals, schedule,
                    and fitness needs.
                </p>

            </article>


            <article class="about-feature-card">

                <div class="about-feature-number">
                    04
                </div>

                <h3>
                    Supportive Community
                </h3>

                <p>
                    Train in a welcoming environment where members can stay
                    motivated and focused.
                </p>

            </article>

        </div>

    </section>


    <!-- Our Values -->

    <section class="about-section about-values">

        <div class="about-section-heading">

            <span class="about-label">
                OUR VALUES
            </span>

            <h2>
                What Drives PulseFit
            </h2>

        </div>


        <div class="about-values-grid">

            <article class="about-value">

                <h3>
                    Consistency
                </h3>

                <p>
                    Small, consistent efforts can create lasting results.
                </p>

            </article>


            <article class="about-value">

                <h3>
                    Progress
                </h3>

                <p>
                    We believe every step forward is part of your journey.
                </p>

            </article>


            <article class="about-value">

                <h3>
                    Motivation
                </h3>

                <p>
                    A positive environment can help you stay committed to
                    your goals.
                </p>

            </article>


            <article class="about-value">

                <h3>
                    Community
                </h3>

                <p>
                    Fitness becomes better when you are surrounded by people
                    who support your journey.
                </p>

            </article>

        </div>

    </section>


    <!-- Final CTA -->

    <section class="about-cta">

        <div class="about-cta-content">

            <span class="about-label">
                START YOUR JOURNEY
            </span>

            <h2>
                Ready to Reach Your Fitness Goals?
            </h2>

            <p>
                Choose your membership and start your PulseFit journey today.
            </p>

            <div class="about-cta-actions">

                <a
                    href="memberships.php"
                    class="btn btn-primary"
                >
                    View Memberships
                </a>

                <a
                    href="contact.php"
                    class="about-secondary-button"
                >
                    Contact Us
                </a>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>