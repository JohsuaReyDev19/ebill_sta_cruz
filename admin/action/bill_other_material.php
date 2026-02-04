<?php
require '../../db/dbconn.php';

header('Content-Type: application/json');

// Check for required POST data
if (
    !isset($_POST['other_billing_id']) ||
    !isset($_POST['due_date'])
) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields.'
    ]);
    exit;
}

$other_billing_id = $_POST['other_billing_id'];
$due_date = $_POST['due_date'];
$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : null;

// Prepare the update query
$query = $con->prepare("
    UPDATE other_billing 
    SET 
        billed = 1, 
        due_date = ?, 
        remarks = ? 
    WHERE other_billing_id = ?
");

if (!$query) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to prepare statement.'
    ]);
    exit;
}

$query->bind_param('ssi', $due_date, $remarks, $other_billing_id);

if ($query->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'The billing has been successfully processed.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to update billing record.'
    ]);
}

$query->close();
$con->close();
