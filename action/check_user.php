<?php
require_once '../db/dbconn.php';

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';

$response = ['usernameExists' => false, 'emailExists' => false];

if (!empty($username)) {
    $stmt = $con->prepare("SELECT 1 FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $response['usernameExists'] = true;
    $stmt->close();
}

if (!empty($email)) {
    $stmt = $con->prepare("SELECT 1 FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $response['emailExists'] = true;
    $stmt->close();
}

echo json_encode($response);
?>
