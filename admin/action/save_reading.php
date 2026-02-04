<?php
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs using mysqli_real_escape_string
    $meters_id = intval($_POST['meters_id']);
    $billing_schedule_id = intval($_POST['billing_schedule_id']);
    $reading_date = mysqli_real_escape_string($con, $_POST['reading_date']);
    $current_reading = floatval($_POST['current_reading']);
    $consumed = floatval($_POST['consumed']);

    // Validate inputs
    if (empty($meters_id) || empty($billing_schedule_id) || empty($reading_date)) {
        echo json_encode(['success' => false, 'message' => 'Invalid or missing input data.']);
        exit;
    }

    // Insert into the database
    $sql = "
        INSERT INTO meter_reading_tbl (meters_id, billing_schedule_id, reading_date, reading, consumed, billed, description)
        VALUES ($meters_id, $billing_schedule_id, '$reading_date', $current_reading, $consumed, 1, 'Monthly Water Consumption Bill')
    ";

    if ($con->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Reading saved successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save reading. Error: ' . $con->error]);
    }

    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
