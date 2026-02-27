<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');

$response = [
    "success" => false,
    "message" => ""
];

if (!isset($_POST['other_bills']) || empty($_POST['other_bills'])) {
    $response["message"] = "No billing records selected.";
    echo json_encode($response);
    exit;
}

$otherBills = $_POST['other_bills'];
$dueDate = date("Y-m-d");

mysqli_begin_transaction($con);

try {
    foreach ($otherBills as $otherId) {
        $otherId = intval($otherId);

        // Check if record exists and not yet billed
        $checkStmt = $con->prepare("
            SELECT other_billing_id, remarks
            FROM other_billing
            WHERE other_billing_id = ?
            AND billed = 0
            AND deleted = 0
        ");
        $checkStmt->bind_param("i", $otherId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows == 0) {
            throw new Exception("One of the selected billing records is already processed.");
        }

        $row = $result->fetch_assoc();
        $existingRemarks = $row['remarks'] ?? '';

        $checkStmt->close();

        // Append new remark instead of overwriting
        $newRemark = "Processed on " . date("Y-m-d");
        if (!empty($existingRemarks)) {
            $remarks = $existingRemarks;
        } else {
            $remarks = $newRemark;
        }

        // Update the record
        $updateStmt = $con->prepare("
            UPDATE other_billing
            SET
                billed = 1,
                due_date = ?,
                remarks = ?
            WHERE other_billing_id = ?
        ");

        if (!$updateStmt) {
            throw new Exception("Failed to prepare update statement.");
        }

        $updateStmt->bind_param("ssi", $dueDate, $remarks, $otherId);

        if (!$updateStmt->execute()) {
            throw new Exception("Failed to update billing record.");
        }

        $updateStmt->close();
    }

    mysqli_commit($con);
    $response["success"] = true;

} catch (Exception $e) {
    mysqli_rollback($con);
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
$con->close();