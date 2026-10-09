<?php

session_start();

$galleryImages = [
    [
        "image" => "dumbbells.jpg",
        "title" => " Dumbbells for strength training ",
        "category" => "Strength"
    ],
    [
        "image" => "barbells.jpg",
        "title" => "Barbells for strength training",
        "category" => "Strength"
    ],
    [
        "image" => "weightPlates.jpg",
        "title" => "Weight Plates for strength training",
        "category" => "Strength"
    ],
    [
        "image" => "kettlebells.jpg",
        "title" => "Kettlebells for strength training",
        "category" => "Strength"
    ],
    [
        "image" => "smithMachine.jpg",
        "title" => "Smith Machine for strength training",
        "category" => "Strength"
    ],
    [
        "image" => "powerRack.jpg",
        "title" => "Power Rack for strength training",
        "category" => "Strength"
    ],
    [
        "image" => "cableMachine.jpg",
        "title" => "Cable Machine for strength training",
        "category" => "Strength"
    ],
    [
        "image" => "legPress.jpg",
        "title" => "Leg Press for strength training",
        "category" => "Strength"
    ],
    [
        "image" => "chestPress.jpg",
        "title" => "Chest Press for strength training",
        "category" => "Strength"
    ],
    [
        "image" => "treadmills.jpg",
        "title" => "Treadmill for cardio training",
        "category" => "Cardio"
    ],
    [
        "image" => "exerciseBike.jpg",
        "title" => "Exercise Bike for cardio training",
        "category" => "Cardio"
    ],
    [
        "image" => "spinBikes.jpg",
        "title" => "Spin Bike for cardio training",
        "category" => "Cardio"
    ],
    [
        "image" => "ellipiticals.jpg",
        "title" => "Ellipitical for cardio training",
        "category" => "Cardio"
    ],
    [
        "image" => "rowingMachine.jpg",
        "title" => "Rowing Machine for cardio training",
        "category" => "Cardio"
    ],
    [
        "image" => "stairClimber.jpg",
        "title" => "Stair Climber for cardio training",
        "category" => "Cardio"
    ],
    [
        "image" => "battleRopes.jpg",
        "title" => "Battle Ropes for functional training",
        "category" => "Functional"
    ],
    [
        "image" => "resistanceBands.jpg",
        "title" => "Resistance Bands for functional training",
        "category" => "Functional"
    ],
    [
        "image" => "TRX.jpg",
        "title" => "TRX for functional training",
        "category" => "Functional"
    ],
    [
        "image" => "plyometricBoxes.jpg",
        "title" => "Plyometric Boxes for functional training",
        "category" => "Functional"
    ],
    [
        "image" => "pull-upBar.jpg",
        "title" => "Pull-Up Bar for functional training",
        "category" => "Functional"
    ],
    [
        "image" => "medicineBalls.jpg",
        "title" => "Medicine Balls for functional training",
        "category" => "Functional"
    ],
    [
        "image" => "foamRoller.jpg",
        "title" => "Foam Roller for recovery training",
        "category" => "Recovery"
    ],
    [
        "image" => "yogaMats.jpg",
        "title" => "Yoga Mat for functional training",
        "category" => "Recovery"
    ],
];

require_once __DIR__ . "/../includes/header.php";
?>

<main class="public-page gallery-page">

    <section class="page-hero">

        <h1>PulseFit Gallery</h1>

        <p>
            Explore our gym, training areas, equipment, and fitness community.
        </p>

    </section>


    <section class="gallery-section">

        <div class="gallery-intro">

            <span class="gallery-label">
                EXPLORE PULSEFIT
            </span>

            <h2>
                See the PulseFit Experience
            </h2>

            <p>
                Take a look at our facilities and training environment.
            </p>

        </div>


        <div class="gallery-grid">

            <?php foreach ($galleryImages as $index => $item): ?>

                <button
                    type="button"
                    class="gallery-item"
                    data-image="/PulseFit/assets/images/<?= htmlspecialchars($item["image"]) ?>"
                    data-title="<?= htmlspecialchars($item["title"]) ?>"
                    aria-label="View <?= htmlspecialchars($item["title"]) ?>"
                >

                    <img
                        src="/PulseFit/assets/images/<?= htmlspecialchars($item["image"]) ?>"
                        alt="<?= htmlspecialchars($item["title"]) ?>"
                        loading="lazy"
                    >

                    <div class="gallery-overlay">

                        <span class="gallery-category">
                            <?= htmlspecialchars($item["category"]) ?>
                        </span>

                        <h3>
                            <?= htmlspecialchars($item["title"]) ?>
                        </h3>

                        <span class="gallery-view">
                            View Image
                        </span>

                    </div>

                </button>

            <?php endforeach; ?>

        </div>

    </section>


    <!-- Image Lightbox -->

    <div
        class="gallery-lightbox"
        id="galleryLightbox"
        aria-hidden="true"
    >

        <button
            type="button"
            class="lightbox-close"
            id="lightboxClose"
            aria-label="Close image viewer"
        >
            ×
        </button>

        <div class="lightbox-content">

            <img
                src=""
                alt=""
                id="lightboxImage"
            >

            <p id="lightboxTitle"></p>

        </div>

    </div>

</main>


<script>

const galleryItems = document.querySelectorAll(".gallery-item");
const lightbox = document.getElementById("galleryLightbox");
const lightboxImage = document.getElementById("lightboxImage");
const lightboxTitle = document.getElementById("lightboxTitle");
const lightboxClose = document.getElementById("lightboxClose");

galleryItems.forEach(item => {

    item.addEventListener("click", () => {

        lightboxImage.src = item.dataset.image;
        lightboxImage.alt = item.dataset.title;
        lightboxTitle.textContent = item.dataset.title;

        lightbox.classList.add("active");
        lightbox.setAttribute("aria-hidden", "false");

        document.body.classList.add("gallery-open");
    });

});


function closeLightbox() {

    lightbox.classList.remove("active");
    lightbox.setAttribute("aria-hidden", "true");

    lightboxImage.src = "";

    document.body.classList.remove("gallery-open");
}


lightboxClose.addEventListener(
    "click",
    closeLightbox
);


lightbox.addEventListener("click", event => {

    if (event.target === lightbox) {
        closeLightbox();
    }

});


document.addEventListener("keydown", event => {

    if (
        event.key === "Escape" &&
        lightbox.classList.contains("active")
    ) {
        closeLightbox();
    }

});

</script>


<?php require_once __DIR__ . "/../includes/footer.php"; ?>