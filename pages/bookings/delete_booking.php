<?php

require_once __DIR__ . "/../../functions/helpers.php";

startSession();

requirePermission("manage_bookings");

$profile_id = (int) $_SESSION["profile_id"];


// ==========================================
// Only Admin And Manager Can Delete
// ==========================================

if (
    $profile_id != 1 &&
    $profile_id != 2
) {

    redirect(loginUrl());
}


// ==========================================
// Include Booking Class
// ==========================================

require_once __DIR__ . "/../../classes/booking.php";

$booking = new Booking();


// ==========================================
// Check Booking ID
// ==========================================

if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {

    redirect("bookings.php");
}

$booking_id = (int) $_GET["id"];


// ==========================================
// Delete Booking
// ==========================================

$booking->deleteBooking($booking_id);


// ==========================================
// Back To Bookings
// ==========================================

redirect("bookings.php");