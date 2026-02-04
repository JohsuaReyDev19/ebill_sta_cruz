<?php
require '../../db/dbconn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zonebook_id'], $_POST['billing_schedule_id'])) {
    $zonebook_id = intval($_POST['zonebook_id']);
    $billing_schedule_id = intval($_POST['billing_schedule_id']);

    // Query to fetch billed accounts with previous and current readings
    $sql = "
        SELECT 
            mrt.meter_reading_id,
            mrt.reading AS current_reading,
            (
                SELECT reading 
                FROM meter_reading_tbl 
                WHERE meters_id = m.meters_id 
                  AND billing_schedule_id < ? 
                  AND deleted = 0 
                ORDER BY reading_date DESC 
                LIMIT 1
            ) AS previous_reading,
            mrt.consumed,
            m.account_no,
            CONCAT(c.first_name, ' ', c.last_name) AS account_name,
            m.meter_no,
            z.zonebook,
            pmt.price_per_cubic_meter,
            bsst.date_due
        FROM meter_reading_tbl mrt 
        INNER JOIN meters m ON mrt.meters_id = m.meters_id
        INNER JOIN concessionaires c ON m.concessionaires_id = c.concessionaires_id
        INNER JOIN zonebook_settings z ON m.zonebook_id = z.zonebook_id
        INNER JOIN billing_schedule_settings bsst ON bsst.billing_schedule_id = mrt.billing_schedule_id
        LEFT JOIN price_matrix pmt ON pmt.classification_id = m.classification_id 
            AND pmt.meter_size_id = m.meter_size_id
        WHERE m.zonebook_id = ? 
          AND mrt.billing_schedule_id = ? 
          AND mrt.billed = 1 
          AND m.deleted = 0 
          AND c.deleted = 0";

    $stmt = $con->prepare($sql);
    $stmt->bind_param('iii', $billing_schedule_id, $zonebook_id, $billing_schedule_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $previousReading = floatval($row['previous_reading']) ?? 0;
            $currentReading = floatval($row['current_reading']) ?? 0;
            $consumed = max(0, $currentReading - $previousReading);

            // Compute Amount Due Based on Consumption
            if ($consumed <= 10) {
                $amountDue = 100.00; // Base rate
            } elseif ($consumed <= 20) {
                $amountDue = $consumed * 18.15;
            } elseif ($consumed <= 30) {
                $amountDue = $consumed * 19.40;
            } elseif ($consumed <= 40) {
                $amountDue = $consumed * 20.65;
            } elseif ($consumed <= 50) {
                $amountDue = $consumed * 22.00;
            } else {
                $amountDue = $consumed * 23.45;
            }

            $data[] = [
                'checkbox' => '<input type="checkbox" class="rowCheckbox" data-id="' . $row['meter_reading_id'] . '" />',
                'account_no' => $row['account_no'],
                'account_name' => $row['account_name'],
                'meter_no' => $row['meter_no'],
                'zonebook' => $row['zonebook'],
                'previous_reading' => number_format($previousReading, 2),
                'current_reading' => number_format($currentReading, 2),
                'consumed' => number_format($consumed, 2),
                'amount_due' => '₱' . number_format($amountDue, 2)
            ];
        }
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No billed accounts found for the selected zone/book and billing schedule.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$con->close();
?>
