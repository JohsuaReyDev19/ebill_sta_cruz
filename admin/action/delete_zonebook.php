<?php
// Include database connection
require '../../db/dbconn.php';

// Check if zonebook_id is provided and numeric
if (isset($_POST['zonebook_id']) && is_numeric($_POST['zonebook_id'])) {

    $zonebook_id = (int) $_POST['zonebook_id'];

    // Prepare DELETE query
    $stmt = $con->prepare("DELETE FROM zonebook_settings WHERE zonebook_id = ?");
    $stmt->bind_param("i", $zonebook_id);

    // Execute query
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
} else {
    echo 'error';
}

// Close connection
$con->close();
?>
