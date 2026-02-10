<?php
require '../../db/dbconn.php';
$response = [];

if (
    isset($_POST['meters_id'], $_POST['units_included'], $_POST['quantity'], $_POST['price_per_unit'], $_POST['units']) &&
    is_numeric($_POST['meters_id']) && is_numeric($_POST['quantity']) && is_numeric($_POST['price_per_unit'])
) {
    $meters_id = intval($_POST['meters_id']);
    $units_included = mysqli_real_escape_string($con, $_POST['units_included']);
    $units = mysqli_real_escape_string($con, $_POST['units']);
    $unit_price = floatval($_POST['price_per_unit']);
    $quantity = floatval($_POST['quantity']);
    $billing_date = date('Y-m-d');

    // Calculate amount due
    $amount_due = $quantity * $unit_price;

    // Build remarks with optional user remarks + material + unit info
    $remarks_input = trim($_POST['remarks'] ?? '');

    $is_status_charge = stripos($remarks_input, 'Charge') !== false;

    if ($is_status_charge) {
        $remarks = mysqli_real_escape_string($con, $remarks_input);
    } else {
        $remarks = $remarks_input !== ''
            ? mysqli_real_escape_string($con, $remarks_input) . " ($units_included in $quantity $units)"
            : "$units_included in $quantity $units";
    }


    $insert_sql = "INSERT INTO other_billing (
        meters_id,
        units_included,
        price_per_units,
        quantity,
        amount_due,
        remarks,
        description,
        billing_date,
        billed
    ) VALUES (
        '$meters_id',
        '$units_included',
        '$unit_price',
        '$quantity',
        '$amount_due',
        '$remarks',
        'Additional material $units_included',
        '$billing_date',
        0
    )";

    if (mysqli_query($con, $insert_sql)) {
        $response = ['status' => 'success', 'message' => 'Material successfully added.'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to insert material: ' . mysqli_error($con)];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Missing or invalid parameters.'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
