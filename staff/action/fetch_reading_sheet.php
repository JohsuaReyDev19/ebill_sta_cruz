<?php
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zonebook_id'], $_POST['billing_schedule_id'])) {
    $zonebook_id = intval($_POST['zonebook_id']);
    $billing_schedule_id = intval($_POST['billing_schedule_id']);
    $show_billed = isset($_POST['show_billed']) && $_POST['show_billed'] == 1;

    if ($show_billed) {
        // Show billed accounts
        $sql = "
            SELECT 
                m.meters_id,
                m.account_no, 
                c.first_name, 
                c.last_name, 
                m.meter_no, 
                COALESCE(z.zonebook, 'Unassigned') AS zonebook,
                r.meter_reading_id,
                r.reading AS current_reading,
                r.consumed AS consumed,
                (SELECT r2.reading 
                 FROM meter_reading_tbl r2
                 WHERE r2.meters_id = m.meters_id 
                   AND r2.billing_schedule_id < ? 
                   AND r2.deleted = 0 
                 ORDER BY r2.reading_date DESC 
                 LIMIT 1) AS previous_reading
            FROM meters m
            INNER JOIN concessionaires c ON m.concessionaires_id = c.concessionaires_id
            LEFT JOIN zonebook_settings z ON m.zonebook_id = z.zonebook_id
            INNER JOIN meter_reading_tbl r 
                ON r.meters_id = m.meters_id 
                AND r.billing_schedule_id = ? 
                AND r.billed = 1 
                AND r.deleted = 0
            WHERE m.zonebook_id = ? 
              AND m.deleted = 0 
              AND c.deleted = 0
        ";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('iii', $billing_schedule_id, $billing_schedule_id, $zonebook_id);

    } else {
        // Show unbilled accounts
        $sql = "
            SELECT 
                m.meters_id,
                m.account_no, 
                c.first_name, 
                c.last_name, 
                m.meter_no, 
                COALESCE(z.zonebook, 'Unassigned') AS zonebook,
                (SELECT r.reading 
                 FROM meter_reading_tbl r 
                 WHERE r.meters_id = m.meters_id 
                   AND r.billing_schedule_id = ? 
                   AND r.deleted = 0 
                 ORDER BY r.reading_date DESC 
                 LIMIT 1) AS current_reading,
                NULL AS consumed,
                (SELECT r.reading 
                 FROM meter_reading_tbl r 
                 WHERE r.meters_id = m.meters_id 
                   AND r.billing_schedule_id < ? 
                   AND r.deleted = 0 
                 ORDER BY r.reading_date DESC 
                 LIMIT 1) AS previous_reading
            FROM meters m
            INNER JOIN concessionaires c ON m.concessionaires_id = c.concessionaires_id
            LEFT JOIN zonebook_settings z ON m.zonebook_id = z.zonebook_id
            WHERE m.zonebook_id = ? 
              AND m.deleted = 0 
              AND c.deleted = 0
              AND NOT EXISTS (
                  SELECT 1 
                  FROM meter_reading_tbl r 
                  WHERE r.meters_id = m.meters_id 
                    AND r.billing_schedule_id = ? 
                    AND r.billed = 1 
                    AND r.deleted = 0
              )
        ";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('iiii', $billing_schedule_id, $billing_schedule_id, $zonebook_id, $billing_schedule_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $metersId = $row['meters_id'];
        $isBilled = $show_billed;

        if ($isBilled) {
            // Billed accounts
            $currentReadingInput = '<input type="number" class="form-control-plaintext current-reading" value="' . htmlspecialchars($row['current_reading']) . '" disabled />';
            // Disabled "Bill" button
            $billBtn = '<button class="btn btn-sm btn-outline-primary shadow-sm regenerate-bill" data-account="' 
                        . $metersId . '" data-reading-id="' . $row['meter_reading_id'] . '" disabled>Bill</button>';
            // Keep update option separate if needed
            $updateBtn = '<button class="btn btn-sm btn-info shadow-sm update-bill" data-account="' 
                         . $metersId . '" data-reading-id="' . $row['meter_reading_id'] . '">Update</button>';

            $action = $billBtn . ' ' . $updateBtn;
        } else {
            // Unbilled accounts
            $currentReadingInput = '<input type="number" class="form-control current-reading border-primary" data-account="' . $metersId . '" value="' . htmlspecialchars($row['current_reading']) . '" />';
            $billBtn = '<button class="btn btn-sm btn-primary shadow-sm generate-bill" data-account="' . $metersId . '">Bill</button>';
            $action = $billBtn;
        }

        $data[] = [
            'checkbox' => '<input type="checkbox" class="select-account" data-account="' . $metersId . '"' . ($isBilled ? ' disabled' : '') . '>',
            'account_no' => $row['account_no'],
            'account_name' => $row['first_name'] . ' ' . $row['last_name'],
            'meter_no' => $row['meter_no'],
            'zonebook' => $row['zonebook'],
            'previous_reading' => $row['previous_reading'] ?? null, // let JS handle N/A
            'current_reading' => $currentReadingInput,
            'consumed' => $row['consumed'] !== null ? floatval($row['consumed']) : null, // just number/null
            'action' => $action
        ];

    }

    echo json_encode(['success' => true, 'data' => $data]);

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$con->close();
?>
