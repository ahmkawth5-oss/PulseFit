<?php

require_once __DIR__ . "/../config/database.php";


// ==========================================
// Base URL
// ==========================================

function baseUrl()
{
    return "/PulseFit";
}


// ==========================================
// Redirect
// ==========================================

function redirect($url)
{
    header("Location: " . $url);
    exit;
}


// ==========================================
// Start Session
// ==========================================

function startSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}


// ==========================================
// Check Login
// ==========================================

function isLoggedIn()
{
    startSession();

    return isset($_SESSION["user_id"]);
}


// ==========================================
// Login URL
// ==========================================

function loginUrl()
{
    return baseUrl() . "/auth/login.php";
}


// ==========================================
// Require Login
// ==========================================

function requireLogin()
{
    startSession();

    if (!isset($_SESSION["user_id"])) {
        redirect(loginUrl());
    }
}


// ==========================================
// Get Current User ID
// ==========================================

function currentUserId()
{
    startSession();

    return isset($_SESSION["user_id"])
        ? (int) $_SESSION["user_id"]
        : null;
}


// ==========================================
// Get Current Profile ID
// ==========================================

function currentProfileId()
{
    startSession();

    return isset($_SESSION["profile_id"])
        ? (int) $_SESSION["profile_id"]
        : null;
}


// ==========================================
// Require Profile
// ==========================================

function requireProfile($profile_id)
{
    requireLogin();

    if (
        !isset($_SESSION["profile_id"]) ||
        (int) $_SESSION["profile_id"] !== (int) $profile_id
    ) {

        http_response_code(403);

        exit("Access Denied");
    }
}


// ==========================================
// Check Permission
// ==========================================

function hasPermission($permission_name)
{
    startSession();

    if (
        !isset($_SESSION["user_id"]) ||
        !isset($_SESSION["profile_id"])
    ) {
        return false;
    }

    global $conn;

    $sql = "
        SELECT COUNT(*) AS total
        FROM profile_permissions pp
        INNER JOIN permissions p
            ON pp.permission_id = p.permission_id
        WHERE pp.profile_id = ?
        AND p.permission_name = ?
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $profile_id = (int) $_SESSION["profile_id"];

    $stmt->bind_param(
        "is",
        $profile_id,
        $permission_name
    );

    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();

    return isset($row["total"]) && (int) $row["total"] > 0;
}


// ==========================================
// Require Permission
// ==========================================

function requirePermission($permission_name)
{
    requireLogin();

    if (!hasPermission($permission_name)) {

        http_response_code(403);

        exit("Access Denied");
    }
}