<?php
// Include your database connection file
require '../../db/dbconn.php';

if (isset($_POST['classification_id'], $_POST['meter_size_id'])) {
    $classification_id = intval($_POST['classification_id']);
    $meter_size_id = intval($_POST['meter_size_id']);

    $stmt = $con->prepare("SELECT * FROM price_matrix WHERE classification_id = ? AND meter_size_id = ? AND deleted = 0");
    $stmt->bind_param("ii", $classification_id, $meter_size_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo ($result->num_rows > 0) ? 'exists' : 'not_exists';
    $stmt->close();
} else {
    echo 'invalid';
}

$con->close();
