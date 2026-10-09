
<?php require_once __DIR__ . "/includes/header.php"; ?>

<main>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>

        <div class="container hero-content">
            <span class="hero-label">WELCOME TO PULSEFIT</span>

            <h1>
                YOUR STRONGER<br>
                SELF STARTS HERE
            </h1>

            <p>
                Train hard. Stay strong. Become your best self.
            </p>

            <div class="hero-actions">
                <a href="/PulseFit/auth/signup.php" class="btn btn-primary">
                    Join Now
                </a>

                <a href="/PulseFit/public/memberships.php" class="btn btn-outline">
                    Explore
                </a>
            </div>
        </div>
    </section>


    <!-- Quick Stats -->

    <section class="section why-section">
    <div class="container">
      <div class="section-heading">
        <h2>COMMIT TO THE PROCESS</h2>
      </div>
    </div>
    

    <section class="stats-section">
        <div class="container stats-grid">

            <div class="stat-item">
                <strong>10+</strong>
                <span>Expert Trainers</span>
            </div>

            <div class="stat-item">
                <strong>100+</strong>
                <span>Active Members</span>
            </div>

            <div class="stat-item">
                <strong>20+</strong>
                <span>Weekly Classes</span>
            </div>

            <div class="stat-item">
                <strong>5+</strong>
                <span>Years Experience</span>
            </div>

        </div>
    </section>
    </section>

    <!-- Why PulseFit -->
    <section class="section why-section">
        <div class="container">

            <div class="section-heading">
                <span>WHY CHOOSE US</span>
                <h2>TRAIN WITH PURPOSE</h2>
                <p>
                    Everything you need to build strength, confidence,
                    and a healthier lifestyle.
                </p>
            </div>

            <div class="feature-grid">

                <article class="feature-card">
                    <div class="feature-icon">🏋️</div>
                    <h3>Modern Equipment</h3>
                    <p>
                        Train with quality equipment designed
                        for effective and comfortable workouts.
                    </p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">💪</div>
                    <h3>Expert Trainers</h3>
                    <p>
                        Get guidance from experienced trainers
                        who help you reach your fitness goals.
                    </p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Personal Training</h3>
                    <p>
                        Follow focused training plans designed
                        around your individual fitness needs.
                    </p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">⏰</div>
                    <h3>Flexible Memberships</h3>
                    <p>
                        Choose a membership that fits your goals,
                        schedule, and lifestyle.
                    </p>
                </article>

            </div>
        </div>
    </section>


    <!-- About Preview -->
    <section class="section about-preview">
        <div class="container about-grid">

            <div class="about-image">
                <img
                    src="/PulseFit/assets/images/gym4.jpg"
                    alt="PulseFit gym interior"
                >
            </div>

            <div class="about-content">
                <span class="section-label">ABOUT PULSEFIT</span>

                <h2>
                    MORE THAN A GYM.
                    <span>A COMMUNITY.</span>
                </h2>

                <p>
                    PulseFit is a modern fitness community built to help
                    people become stronger, healthier, and more confident.
                </p>

                <p>
                    Whether you are starting your fitness journey or
                    pushing toward your next goal, we are here to support you.
                </p>

                <a href="/PulseFit/public/about.php" class="btn btn-primary">
                    Learn More
                </a>
            </div>

        </div>
    </section>


    <!-- Membership Plans -->
    <section class="section memberships-preview">
        <div class="container">

            <div class="section-heading">
                <span>MEMBERSHIPS</span>
                <h2>CHOOSE YOUR PLAN</h2>
                <p>
                    Find the membership that matches your fitness goals.
                </p>
            </div>

            <div class="membership-grid">

                <article class="membership-card">
                    <h3>Basic</h3>

                    <div class="membership-price">
                        <span>$</span>25.01
                    </div>

                    <p class="membership-duration">1 Month</p>

                    <ul>
                        <li>✔ Gym Access</li>
                        <li>✔ Basic Equipment</li>
                        <li>✔ Locker Access</li>
                    </ul>

                    <a
                        href="/PulseFit/public/memberships.php"
                        class="btn btn-outline-dark"
                    >
                        View Plan
                    </a>
                </article>


                <article class="membership-card featured">
                    <div class="popular-badge">
                        ★ Most Popular
                    </div>

                    <h3>Standard</h3>

                    <div class="membership-price">
                        <span>$</span>65
                    </div>

                    <p class="membership-duration">3 Months</p>

                    <ul>
                        <li>✔ Gym Access</li>
                        <li>✔ Group Classes</li>
                        <li>✔ Trainer Support</li>
                    </ul>

                    <a
                        href="/PulseFit/public/memberships.php"
                        class="btn btn-primary"
                    >
                        View Plan
                    </a>
                </article>


                <article class="membership-card">
                    <h3>VIP</h3>

                    <div class="membership-price">
                        <span>$</span>200
                    </div>

                    <p class="membership-duration">12 Months</p>

                    <ul>
                        <li>✔ Full Gym Access</li>
                        <li>✔ All Group Classes</li>
                        <li>✔ Personal Training Support</li>
                    </ul>

                    <a
                        href="/PulseFit/public/memberships.php"
                        class="btn btn-outline-dark"
                    >
                        View Plan
                    </a>
                </article>

            </div>

        </div>
    </section>


    <!-- Trainers Preview -->
    <section class="section trainers-preview">
        <div class="container">

            <div class="section-heading">
                <span>OUR TEAM</span>
                <h2>MEET OUR TRAINERS</h2>
                <p>
                    Experienced trainers ready to help you train smarter.
                </p>
            </div>

            <div class="trainer-grid">

                <article class="trainer-card">
                    <div class="trainer-image">
                        <img
                            src="/PulseFit/assets/images/trainer-1.jpg"
                            alt="PulseFit trainer"
                        >
                    </div>

                    <div class="trainer-info">
                        <h3>Zaid</h3>
                        <p>Karate</p>

                        <a href="/PulseFit/public/trainers.php">
                            View 
                        </a>
                    </div>
                </article>


                <article class="trainer-card">
                    <div class="trainer-image">
                        <img
                            src="/PulseFit/assets/images/trainer-2.jpg"
                            alt="PulseFit trainer"
                        >
                    </div>

                    <div class="trainer-info">
                        <h3>Reem Ali</h3>
                        <p>Personal Training</p>

                        <a href="/PulseFit/public/trainers.php">
                            View
                        </a>
                    </div>
                </article>


                <article class="trainer-card">
                    <div class="trainer-image">
                        <img
                            src="/PulseFit/assets/images/trainer-3.jpg"
                            alt="PulseFit trainer"
                        >
                    </div>

                    <div class="trainer-info">
                        <h3>Mona Saleh</h3>
                        <p>Nutrition</p>

                        <a href="/PulseFit/public/trainers.php">
                            View
                        </a>
                    </div>
                </article>

            </div>

        </div>
    </section>


    <!-- Classes Preview -->
    <section class="section classes-preview">
        <div class="container">

            <div class="section-heading">
                <span>TRAIN WITH US</span>
                <h2>UPCOMING CLASSES</h2>
                <p>
                    Find a class that matches your energy and goals.
                </p>
            </div>

            <div class="class-grid">

                <article class="class-card">
                    <div class="class-date">
                        <strong>12</strong>
                        <span>SEP</span>
                    </div>

                    <div class="class-info">
                        <h3>Strength Training</h3>
                        <p>⏰ 5:00 PM</p>
                        <p>👤 Ahmed Ali</p>
                    </div>

                    <a
                        href="/PulseFit/public/classes.php"
                        class="btn btn-primary"
                    >
                        Book Class
                    </a>
                </article>


                <article class="class-card">
                    <div class="class-date">
                        <strong>13</strong>
                        <span>SEP</span>
                    </div>

                    <div class="class-info">
                        <h3>HIIT Workout</h3>
                        <p>⏰ 6:00 PM</p>
                        <p>👤 Mohammed Saleh</p>
                    </div>

                    <a
                        href="/PulseFit/public/classes.php"
                        class="btn btn-primary"
                    >
                        Book Class
                    </a>
                </article>


                <article class="class-card">
                    <div class="class-date">
                        <strong>14</strong>
                        <span>SEP</span>
                    </div>

                    <div class="class-info">
                        <h3>Fitness Training</h3>
                        <p>⏰ 7:00 PM</p>
                        <p>👤 Omar Hassan</p>
                    </div>

                    <a
                        href="/PulseFit/public/classes.php"
                        class="btn btn-primary"
                    >
                        Book Class
                    </a>
                </article>

            </div>

        </div>
    </section>


    <!-- Gallery Preview -->
    <section class="section gallery-preview">
        <div class="container">

            <div class="section-heading">
                <span>OUR GYM</span>
                <h2>INSIDE PULSEFIT</h2>
                <p>
                    Take a look at our training environment.
                </p>
            </div>

            <div class="gallery-grid">

                <div class="gallery-item">
                    <img
                        src="/PulseFit/assets/images/gym2.jpg"
                        alt="PulseFit equipment"
                    >
                </div>

                <div class="gallery-item">
                    <img
                        src="/PulseFit/assets/images/gym.jpg"
                        alt="PulseFit training"
                    >
                </div>

                <div class="gallery-item">
                    <img
                        src="/PulseFit/assets/images/gym4.jpg"
                        alt="PulseFit gym"
                    >
                </div>

                <div class="gallery-item">
                    <img
                        src="/PulseFit/assets/images/gym3.jpg"
                        alt="PulseFit workout"
                    >
                </div>

            </div>

            <div class="center-button">
                <a
                    href="/PulseFit/public/gallery.php"
                    class="btn btn-outline-dark"
                >
                    View Gallery
                </a>
            </div>

        </div>
   
            <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 

        <div class="section-heading">
                <span>START TODAY</span>

                <h2>READY TO GET STRONGER?</h2>

                <p>
                    Your fitness journey starts with one decision.
                </p>

                <a
                    href="/PulseFit/auth/signup.php"
                    class="btn btn-primary"
                >
                    Join PulseFit
                </a>
            </div>

        </div>
    </section>

</main>


<?php require_once __DIR__ . "/includes/footer.php"; ?>
