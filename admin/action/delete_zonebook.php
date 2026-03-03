<?php
// Include database connection
require '../../db/dbconn.php';
header('Content-Type: application/json'); // return JSON

if (isset($_POST['zonebook_id']) && is_numeric($_POST['zonebook_id'])) {

    $zonebook_id = (int) $_POST['zonebook_id'];

    // Optional: Soft delete instead of permanent delete
    // $stmt = $con->prepare("UPDATE zonebook_settings SET deleted = 1 WHERE zonebook_id = ?");
    $stmt = $con->prepare("DELETE FROM zonebook_settings WHERE zonebook_id = ?");
    $stmt->bind_param("i", $zonebook_id);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Zone/Book deleted successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete Zone/Book. Please try again.'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid Zone/Book ID.'
    ]);
}

$con->close();