<?php

require_once __DIR__ . "/../../functions/helpers.php";

startSession();

requireLogin();

$profile_id = (int) $_SESSION["profile_id"];


// ==========================================
// Only Admin / Manager Can Delete
// ==========================================

if ($profile_id != 1 && $profile_id != 2) {

    redirect(loginUrl());

}


// ==========================================
// Include Attendance Class
// ==========================================

require_once __DIR__ . "/../../classes/attendance.php";

$attendance = new Attendance();


// ==========================================
// Check Attendance ID
// ==========================================

if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {

    redirect("attendance.php");

}

$attendance_id = (int) $_GET["id"];


// ==========================================
// Delete Attendance
// ==========================================

$attendance->deleteAttendance($attendance_id);


// ==========================================
// Return To Attendance
// ==========================================

redirect("attendance.php");