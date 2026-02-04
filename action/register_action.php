<?php
require '../db/dbconn.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name   = strtoupper(mysqli_real_escape_string($con, $_POST['first_name']));
    $middle_name  = strtoupper(mysqli_real_escape_string($con, $_POST['middle_name']));
    $last_name    = strtoupper(mysqli_real_escape_string($con, $_POST['last_name']));
    $suffix_name  = strtoupper(mysqli_real_escape_string($con, $_POST['suffix_name']));
    $username     = mysqli_real_escape_string($con, $_POST['username']);
    $email        = mysqli_real_escape_string($con, $_POST['email']);
    $password     = mysqli_real_escape_string($con, $_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check duplicates
    $checkSql = "SELECT * FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";
    $checkResult = $con->query($checkSql);

    if ($checkResult && $checkResult->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Username or email already exists."]);
        exit;
    }

    $sql = "INSERT INTO users (first_name, middle_name, last_name, suffix_name, username, email, password, role, status) 
            VALUES ('$first_name', '$middle_name', '$last_name', '$suffix_name', '$username', '$email', '$hashed_password', 2, 0)";

    if ($con->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Registration successful. Please wait for admin approval."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $con->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
