<?php
require '../../db/dbconn.php'; // Adjust if needed

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $meter_id = $_POST['meter_id'];
    $meter_reading_id = $_POST["meter_reading_id"];
    $description = $_POST["description"];
    $amount_due = $_POST["amount_due"];
    $due_date = $_POST["due_date"];
    $amount_paid = $_POST["amount_paid"];
    $amount_change = $_POST["amount_change"];

    // Validate required fields
    if (empty($meter_reading_id) || empty($description) || empty($amount_due) || empty($due_date) || empty($amount_paid)) {
        echo json_encode(["status" => "error", "message" => "Missing required fields."]);
        exit;
    }

    $updateSql = "UPDATE meters SET deleted = 1, bill = 1 WHERE meters_id = ?";
        $updateStmt = $con->prepare($updateSql);
        $updateStmt->bind_param("i", $meter_id);

        if (!$updateStmt->execute()) {
            throw new Exception("Failed to update meter status.");
        }


    // Insert into the collection table
    $query = "INSERT INTO collection (meter_reading_id, description, amount_due, due_date, amount_paid, amount_change, payment_date)
              VALUES (?, ?, ?, ?, ?, ?, NOW())";

    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("isdsdd", $meter_reading_id, $description, $amount_due, $due_date, $amount_paid, $amount_change);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Payment recorded successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to record payment."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Database error."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>


