<?php
// Start the session
session_start();

// Destroy the session
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session

// Redirect to the login page (or any other page you prefer)
header("Location: login.php");
exit();
?>
