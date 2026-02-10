<?php
require '../../db/dbconn.php';
require '../../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $meters_id = (int) $_POST['meters_id'];
    $status = (int) $_POST['status'];

    if ($meters_id <= 0 || !in_array($status, [0,1,2])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit;
    }

    $stmt = $con->prepare("UPDATE meters SET service_status_id = ? WHERE meters_id = ?");
    $stmt->bind_param("ii", $status, $meters_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No rows updated']);
    }
}
?>
