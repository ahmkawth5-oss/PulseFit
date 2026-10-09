
/* MENU */
/* Mobile Navigation */

const menuToggle = document.getElementById("menuToggle");
const mainNav = document.getElementById("mainNav");

if (menuToggle && mainNav) {
    menuToggle.addEventListener("click", function () {
        mainNav.classList.toggle("show");
    });
}


/* Close Mobile Navigation After Clicking a Link */

if (mainNav) {
    const navLinks = mainNav.querySelectorAll("a");

    navLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            mainNav.classList.remove("show");
        });
    });
}