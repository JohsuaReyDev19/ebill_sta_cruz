<?php
session_start();
require '../db/dbconn.php';
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $response['message'] = 'Please enter both username and password.';
        echo json_encode($response);
        exit;
    }

    // Fetch user by username or email
    $stmt = $con->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND deleted = 0 LIMIT 1");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $response['message'] = 'Username does not exist.';
        echo json_encode($response);
        exit;
    }

    $user = $result->fetch_assoc();

    // Verify password
    if (!password_verify($password, $user['password'])) {
        $response['message'] = 'Incorrect password.';
        echo json_encode($response);
        exit;
    }

    // Check account status
    if ($user['status'] != 1) {
        $response['message'] = 'Your account is not approved yet.';
        echo json_encode($response);
        exit;
    }

    // Set session variables
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['fullname'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['role'] = $user['role']; // 1=admin, 2=staff

    // Store permissions for sidebar
    $_SESSION['permissions'] = [
        'concessionaires' => $user['concessionaires'],
        'billing_system' => $user['billing_system'],
        'collecting_system' => $user['collecting_system'],
        'accounting_system' => $user['accounting_system'],
        'manage_user' => $user['manage_user'],
        'system_settings' => $user['system_settings']
    ];

    // Fetch system settings (profile and system name)
    $settingsResult = $con->query("SELECT system_name, system_profile FROM system_settings WHERE settings_id = 1 LIMIT 1");
    if ($settingsResult && $settingsResult->num_rows > 0) {
        $settings = $settingsResult->fetch_assoc();
        $_SESSION['system_name'] = $settings['system_name'];
        $_SESSION['system_profile'] = $settings['system_profile'];
    } else {
        $_SESSION['system_name'] = 'e-Billing System';
        $_SESSION['system_profile'] = 'mmwd.png';
    }

    // Return success JSON
    $response['status'] = 'success';
    $response['message'] = 'Login successful';
    $response['redirect'] = 'index.php';

    echo json_encode($response);
    exit;
}
?>
