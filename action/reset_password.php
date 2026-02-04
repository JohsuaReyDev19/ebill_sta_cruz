<?php
// Include your database connection file
require '../db/dbconn.php';

// Check if user_id and password are provided
if (isset($_POST['user_id']) && is_numeric($_POST['user_id']) && isset($_POST['password'])) {
    // Sanitize the inputs to prevent SQL injection
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Hash the password before storing it in the database (using bcrypt)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // SQL query to update the user's password
    $sql = "UPDATE users SET password = '$hashed_password' WHERE user_id = '$user_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error';
    }
} else {
    // If user_id or password is not provided, return error
    echo 'error';
}

// Close the database connection
mysqli_close($con);
?>
