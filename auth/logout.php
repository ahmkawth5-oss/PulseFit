<?php

session_start();

session_unset();

// Destroy session
$_SESSION = [];
session_destroy();

// Redirect to login
header("Location: /PulseFit/auth/login.php");
exit;

?>