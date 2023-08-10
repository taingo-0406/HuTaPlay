<?php
// Start the session
session_start();

// Check if the user is not logged in or does not have the admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // The user is not logged in or does not have the admin role
    // Redirect to the login page or show an error message
    header('Location: ../login.php');
    exit;
}
?>
