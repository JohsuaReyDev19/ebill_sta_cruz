<?php
require '../../db/dbconn.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    // Approve account
    $sql = "UPDATE users SET deleted = 1 WHERE user_id = '$user_id'";

    if (mysqli_query($con, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}

mysqli_close($con);
?>
