<?php
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $meter_reading_id   = intval($_POST['meter_reading_id']);
    $meters_id          = intval($_POST['meters_id']);
    $billing_schedule_id = intval($_POST['billing_schedule_id']);
    $reading_date       = mysqli_real_escape_string($con, $_POST['reading_date']);
    $current_reading    = floatval($_POST['current_reading']);
    $consumed           = floatval($_POST['consumed']);

    // Validate
    if (empty($meter_reading_id) || empty($meters_id) || empty($billing_schedule_id) || empty($reading_date)) {
        echo json_encode(['success' => false, 'message' => 'Invalid or missing input data.']);
        exit;
    }

    // Update instead of insert
    $sql = "
        UPDATE meter_reading_tbl
        SET reading = $current_reading,
            consumed = $consumed,
            reading_date = '$reading_date',
            billed = 1,
            description = 'Monthly Water Consumption Bill'
        WHERE meter_reading_id = $meter_reading_id
          AND meters_id = $meters_id
          AND billing_schedule_id = $billing_schedule_id
          AND deleted = 0
    ";

    if ($con->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Reading updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update reading. Error: ' . $con->error]);
    }

    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
