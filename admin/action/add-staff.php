<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ===============================
    // PERSONAL INFORMATION
    // ===============================
    $first_name   = trim($_POST['first_name'] ?? '');
    $middle_name  = trim($_POST['middle_name'] ?? '');
    $last_name    = trim($_POST['last_name'] ?? '');
    $suffix_name  = trim($_POST['suffix_name'] ?? 'N/A');
    $account_type = trim($_POST['accountType'] ?? 'Staff');
    $position     = trim($_POST['position'] ?? '');

    // ===============================
    // CONTACT INFORMATION
    // ===============================
    $contact_no   = trim($_POST['contact_no'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');

    // ===============================
    // PERMISSIONS
    // ===============================
    $concessionaires   = isset($_POST['concessionaires']) ? 1 : 0;
    $billing_system    = isset($_POST['billing_system']) ? 1 : 0;
    $collecting_system = isset($_POST['collecting_system']) ? 1 : 0;
    $accounting_system = isset($_POST['accounting_system']) ? 1 : 0;
    $manage_user       = isset($_POST['manage_user']) ? 1 : 0;
    $system_settings   = isset($_POST['system_settings']) ? 1 : 0;

    // ===============================
    // BASIC VALIDATION
    // ===============================
    if (
        empty($first_name) || 
        empty($last_name) || 
        empty($account_type) || 
        empty($position) || 
        empty($contact_no) || 
        empty($email) ||
        empty($username)
    ) {
        echo json_encode(['status'=>'error','message'=>'All required fields must be filled.']);
        exit;
    }

    // ===============================
    // CHECK DUPLICATE EMAIL
    // ===============================
    $check = $con->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(['status'=>'error','message'=>'Email already exists.']);
        exit;
    }
    $check->close();

    // ===============================
    // DEFAULT PASSWORD
    // ===============================
    $password = password_hash('DefaultPassword123!', PASSWORD_DEFAULT);

    // ===============================
    // PROFILE UPLOAD
    // ===============================
    $profile_file = NULL;

    if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {

        $tmp  = $_FILES['profile']['tmp_name'];
        $name = $_FILES['profile']['name'];
        $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        $allowed = ['png','jpg','jpeg','gif','webp'];

        if (!in_array($ext, $allowed)) {
            echo json_encode(['status'=>'error','message'=>'Invalid image type.']);
            exit;
        }

        $profile_file = uniqid('profile_', true) . '.' . $ext;
        $uploadDir = '../../upload/profile';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($tmp, $uploadDir . $profile_file)) {
            echo json_encode(['status'=>'error','message'=>'Failed to upload profile image.']);
            exit;
        }
    } else {
        echo json_encode(['status'=>'error','message'=>'Profile image is required.']);
        exit;
    }
    $status = 1;
    $role = 2;

    // ===============================
    // INSERT USER
    // ===============================
    $stmt = $con->prepare("
        INSERT INTO users (
            first_name, middle_name, last_name, suffix_name,username,
            account_type, position, contact_no, email,
            password, profile,
            concessionaires, billing_system, collecting_system,
            accounting_system, manage_user, system_settings, status, role
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        echo json_encode(['status'=>'error','message'=>'Prepare failed: '.$con->error]);
        exit;
    }

    $stmt->bind_param(
        "sssssssssssiiiiiiii",
        $first_name,
        $middle_name,
        $last_name,
        $suffix_name,
        $username,
        $account_type,
        $position,
        $contact_no,
        $email,
        $password,
        $profile_file,
        $concessionaires,
        $billing_system,
        $collecting_system,
        $accounting_system,
        $manage_user,
        $system_settings,
        $status,
        $role
    );

    if ($stmt->execute()) {
        echo json_encode([
            'status'=>'success',
            'message'=>'User added successfully.'
        ]);
    } else {
        echo json_encode([
            'status'=>'error',
            'message'=>'Insert failed: '.$stmt->error
        ]);
    }

    $stmt->close();
    exit;
}
?>
