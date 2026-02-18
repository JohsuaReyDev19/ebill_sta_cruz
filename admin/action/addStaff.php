<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Composer autoload for PHPMailer

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
    $username     = trim($_POST['username'] ?? '');

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
    // GENERATE RANDOM PASSWORD
    // ===============================
    function generateRandomPassword($length = 12) {
        return bin2hex(random_bytes($length / 2));
    }

    $plain_password = generateRandomPassword(12);
    $password = password_hash($plain_password, PASSWORD_DEFAULT);

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
        $uploadDir = '../../upload/profile/';

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
            first_name, middle_name, last_name, suffix_name, username,
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
        $user_id = $stmt->insert_id;

        // ===============================
        // CREATE PASSWORD RESET TOKEN
        // ===============================
        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

        $stmtToken = $con->prepare("INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmtToken->bind_param("iss", $user_id, $token, $expiry);
        $stmtToken->execute();

        $resetLink = "https://stacruzwd-dev.projectbeta.net/set_password.php?token=$token";

        // ===============================
        // SEND EMAIL VIA PHPMailer
        // ===============================

        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'burcejosh19@gmail.com';
            $mail->Password   = 'mwbt bwct grds fvsr';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('burcejosh19@gmail.com', 'STA CRUZ WD');
            $mail->addAddress($email, "$first_name $last_name");

            $mail->isHTML(true);
            $mail->Subject = 'Your Staff Account Password';
            $mail->Body    = "
                Hello $first_name,<br><br>
                Your staff account has been created.<br>
                <b>Username:</b> $username<br>
                <b>Password:</b> $plain_password<br><br>
                You can <a href='$resetLink'>click here to change your password</a> or use the generated password.<br><br>
                Thanks,<br>
                Admin Team
            ";

            $mail->send();
            echo json_encode(['status'=>'success','message'=>'User added and email sent successfully.']);

        } catch (Exception $e) {
            echo json_encode(['status'=>'error','message'=>"User added but email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        }

    } else {
        echo json_encode(['status'=>'error','message'=>'Insert failed: '.$stmt->error]);
    }

    $stmt->close();
    exit;
}
?>
