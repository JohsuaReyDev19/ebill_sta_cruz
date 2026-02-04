<?php
session_start();

function checkSession() {
    // Check if the 'user_id' session variable is not set
    if (!isset($_SESSION['user_id'])) {
        redirectToLogin("You must login first!");
    }

    // Check the role and redirect accordingly
    if ($_SESSION['role'] == 1) {
        // Redirect to admin dashboard
        // redirectTo("../admin/index.php");
    } elseif ($_SESSION['role'] == 2) {
        // Redirect to faculty dashboard
        redirectTo("../staff/index.php");
    } else {
        // Redirect to login page with an error message
        redirectToLogin("You must login first!");
    }
}

function redirectToLogin($errorMessage) {
    $_SESSION['error'] = $errorMessage;
    header("Location: ../login.php");
    exit;
}

function redirectTo($location) {
    header("Location: $location");
    exit;
}

?>
