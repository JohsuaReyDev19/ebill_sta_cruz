<?php
session_start();
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $system_name = trim($_POST['system_name'] ?? '');

    if ($system_name === '') {
        echo json_encode(['status' => 'error', 'message' => 'System name is required.']);
        exit;
    }

    $sql = "UPDATE system_settings SET system_name = ? WHERE settings_id = 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $system_name);

    if ($stmt->execute()) {
        $_SESSION['system_name'] = $system_name;
        echo json_encode(['status' => 'success', 'message' => 'System name updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed.']);
    }

    $stmt->close();
    $con->close();
}
