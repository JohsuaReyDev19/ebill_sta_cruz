<?php
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input values
    $classification_id = intval($_POST['classification_id']);
    $meter_size_id = intval($_POST['meter_size_id']);
    $price_per_cubic_meter = floatval($_POST['price_per_cubic_meter']);

    // Prepare SQL insert statement
    $sql = "INSERT INTO price_matrix (classification_id, meter_size_id, price_per_cubic_meter) 
            VALUES (?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("iid", $classification_id, $meter_size_id, $price_per_cubic_meter);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error: ' . $stmt->error;
    }

    $stmt->close();
} else {
    echo 'error: Invalid request method.';
}

$con->close();
