<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

// Unset all of the session variables.
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to the login page or wherever you want to send the user after logging out.
header("Location: login-page.php");
exit();
?>
