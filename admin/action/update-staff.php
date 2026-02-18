<?php
require '../../db/dbconn.php'; // adjust path

// Use POST user_id, not GET
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
if ($user_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid User ID']);
    exit;
}

// Fetch user info
$stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? AND deleted = 0 LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

// Now process the update (personal info, account info, permissions, profile upload)
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$middle_name = $_POST['middle_name'] ?? '';
$suffix_name = $_POST['suffix_name'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$position = $_POST['position'] ?? '';
$accountType = $_POST['accountType'] ?? 'Staff';
$contact_no = $_POST['contact_no'] ?? '';

// Permissions
$permissions = ['concessionaires','billing_system','collecting_system','accounting_system','manage_user','system_settings'];
$perms_update = [];
foreach ($permissions as $perm) {
    $perms_update[$perm] = isset($_POST[$perm]) ? 1 : 0;
}

// Profile upload logic (optional)
$profilePath = $user['profile'] ?? '../img/avatar.png';
if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/profile/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $fileTmp = $_FILES['profile']['tmp_name'];
    $fileName = uniqid().'_'.basename($_FILES['profile']['name']);
    $targetFile = $uploadDir . $fileName;
    if (move_uploaded_file($fileTmp, $targetFile)) {
        $profilePath = $targetFile;
    }
}

// Update query
$stmt = $con->prepare("
    UPDATE users SET 
        first_name=?, middle_name=?, last_name=?, suffix_name=?,
        username=?, email=?, contact_no=?, role=?,
        concessionaires=?, billing_system=?, collecting_system=?,
        accounting_system=?, manage_user=?, system_settings=?, profile=?
    WHERE user_id=?
");

$role = ($accountType==='Admin')?1:2;

$stmt->bind_param(
    "sssssssiiiiiiisi",
    $first_name, $middle_name, $last_name, $suffix_name,
    $username, $email, $contact_no, $role,
    $perms_update['concessionaires'], $perms_update['billing_system'],
    $perms_update['collecting_system'], $perms_update['accounting_system'],
    $perms_update['manage_user'], $perms_update['system_settings'], $profilePath,
    $user_id
);

if ($stmt->execute()) {
    echo json_encode(['success'=>true,'message'=>'User updated successfully!']);
} else {
    echo json_encode(['success'=>false,'message'=>'Failed to update user.']);
}
?>
