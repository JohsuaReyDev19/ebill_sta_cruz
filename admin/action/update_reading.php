<?php
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}


/* =========================
   VALIDATION (CORRECT)
========================= */
if (
    !isset(
        $_POST['meter_reading_id'],
        $_POST['meters_id'],
        $_POST['billing_schedule_id'],
        $_POST['reading_date'],
        $_POST['current_reading'],
        $_POST['consumed']
    )
) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid or missing input data.'
    ]);
    exit;
}

/* =========================
   SAFE CASTING
========================= */
$meter_reading_id    = (int) $_POST['meter_reading_id'];
$meters_id           = (int) $_POST['meters_id'];
$billing_schedule_id = (int) $_POST['billing_schedule_id'];
$reading_date        = mysqli_real_escape_string($con, $_POST['reading_date']);
$current_reading     = (float) $_POST['current_reading'];
$consumed            = (float) $_POST['consumed'];

/* =========================
   FINAL SANITY CHECK
========================= */
if ($meter_reading_id <= 0 || $meters_id <= 0 || $billing_schedule_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid record identifiers.'
    ]);
    exit;
}

/* =========================
   UPDATE QUERY
========================= */
$sql = "
    UPDATE meter_reading_tbl
    SET reading = ?,
        consumed = ?,
        reading_date = ?,
        billed = 1,
        description = 'Monthly Water Consumption Bill'
    WHERE meter_reading_id = ?
      AND meters_id = ?
      AND billing_schedule_id = ?
      AND deleted = 0
";

$stmt = $con->prepare($sql);
$stmt->bind_param(
    'ddsiii',
    $current_reading,
    $consumed,
    $reading_date,
    $meter_reading_id,
    $meters_id,
    $billing_schedule_id
);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Reading updated successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No changes detected.'
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update reading.'
    ]);
}

$stmt->close();
$con->close();
