<?php
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['billing_schedule_id'])) {
    $billing_schedule_id = intval($_POST['billing_schedule_id']);

    // Fetch the billing schedule details
    $sql = "SELECT reading_date, date_covered_from, date_covered_to, date_due, date_disconnection 
            FROM billing_schedule_settings 
            WHERE billing_schedule_id = ? AND deleted = 0";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $billing_schedule_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Format the dates
        $formattedData = [
            'reading_date' => date('F j, Y', strtotime($data['reading_date'])),
            'date_covered_from' => date('F j, Y', strtotime($data['date_covered_from'])),
            'date_covered_to' => date('F j, Y', strtotime($data['date_covered_to'])),
            'date_due' => date('F j, Y', strtotime($data['date_due'])),
            'date_disconnection' => date('F j, Y', strtotime($data['date_disconnection']))
        ];

        echo json_encode(['success' => true, 'data' => $formattedData]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Billing schedule not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$con->close();
?>
