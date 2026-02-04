<?php
require '../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    // Escape the user_id to prevent SQL injection
    $user_id = mysqli_real_escape_string($con, $user_id);

    $query = "SELECT password FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            echo 'verified';
        } else {
            echo 'not_verified';
        }
    } else {
        echo 'not_verified';
    }

    // Close the database connection
    mysqli_close($con);
}
?>