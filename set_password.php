<?php
require_once "function/check_session.php";
require './db/dbconn.php';

// Check if user is logged in and redirect
redirectToDashboard();

// Get token from URL
$token = $_GET['token'] ?? '';

if (!$token) {
    die('Invalid or missing token.');
}

// Fetch token data
$stmt = $con->prepare("SELECT prt.user_id, prt.expires_at, prt.used, u.username 
                       FROM password_reset_tokens prt
                       JOIN users u ON prt.user_id = u.user_id
                       WHERE prt.token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$tokenData = $result->fetch_assoc();
$stmt->close();

if (!$tokenData) {
    die('Invalid token.');
}

if ($tokenData['used'] == 1 || strtotime($tokenData['expires_at']) < time()) {
    die('This link has expired or has already been used.');
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $use_generated = isset($_POST['use_generated']);

    if (!$use_generated && (empty($new_password) || empty($confirm_password))) {
        $error = "Please enter and confirm your new password.";
    } elseif (!$use_generated && $new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Decide password
        if ($use_generated) {
            // Keep existing password (already hashed in DB)
            $stmt = $con->prepare("UPDATE password_reset_tokens SET used = 1 WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->close();
        } else {
            // Hash new password
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $con->prepare("UPDATE users u 
                                   JOIN password_reset_tokens prt ON u.user_id = prt.user_id
                                   SET u.password = ?, prt.used = 1 
                                   WHERE prt.token = ?");
            $stmt->bind_param("ss", $hashed, $token);
            $stmt->execute();
            $stmt->close();
        }
        $success = "Password updated successfully! You can now log in.";
    }
}

// Fetch current settings from the database
$sql = "SELECT system_name, system_profile FROM system_settings WHERE settings_id = 1";
$result = $con->query($sql);
$currentSettings = $result->fetch_assoc() ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Set Password - <?php echo $currentSettings['system_name'] ?? 'e-Billing'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/login-style.php" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<div class="container d-flex align-items-center min-vh-100">
    <div class="row g-0 justify-content-center">
        <!-- TITLE -->
        <div class="col-lg-5 offset-lg-1 mx-0 px-0">
            <div id="title-container">
                <img class="covid-image" src="./img/<?php echo $currentSettings['system_profile'] ?? 'mmwd.png'; ?>" alt="System Logo">
                <h2>e-Billing</h2>
                <h3><?php echo $currentSettings['system_name'] ?? ''; ?></h3>
                <p>Set your account password below.</p>
            </div>
        </div>
        <!-- FORM -->
        <div class="col-lg-7 mx-0 px-0">
            <div id="qbox-container">
                <?php if(isset($error)): ?>
                    <script>Swal.fire({icon: 'error', title: 'Error', text: '<?php echo $error; ?>'});</script>
                <?php endif; ?>
                <?php if(isset($success)): ?>
                    <script>Swal.fire({icon: 'success', title: 'Success', text: '<?php echo $success; ?>'}).then(()=>{window.location.href='login.php';});</script>
                <?php endif; ?>
                <form method="POST">
                    <h4 class="mt-5">Set Your Password</h4>
                    <hr>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" id="useGenerated" name="use_generated">
                        <label class="form-check-label" for="useGenerated">
                            Use the generated password sent via email
                        </label>
                    </div>
                    <div id="newPasswordFields">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="new_password" placeholder="New Password">
                            <label>New Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                            <label>Confirm Password</label>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">Set Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle new password fields if "use generated password" is checked
$('#useGenerated').change(function(){
    if($(this).is(':checked')){
        $('#newPasswordFields').hide();
    } else {
        $('#newPasswordFields').show();
    }
});
</script>
</body>
</html>
