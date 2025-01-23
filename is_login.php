<?php
session_start();

function checkLogin() {
    // Check if the session variables for the user are set
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit(); // Stop further execution
    }
}

?>
