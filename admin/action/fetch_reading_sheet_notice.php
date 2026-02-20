<?php
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zonebook_id'], $_POST['billing_schedule_id'])) {

    $zonebook_id = intval($_POST['zonebook_id']);
    $billing_schedule_id = intval($_POST['billing_schedule_id']);

    $sql = "
        SELECT
            mrt.meter_reading_id,
            mrt.reading_date,
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
            m.account_no,
            CONCAT(c.last_name, ', ', c.first_name) AS account_name,
            c.discount,
            COALESCE(b.barangay, 'N/A') AS barangay_name,
            m.meter_no,
            COALESCE(z.zonebook, 'Unassigned') AS zonebook,
            ms.meter_size,
            cs.classification,
            bsst.date_due,
            mpm.minimum_price,
            mpm.charge_0,
            mpm.charge_11_20,
            mpm.charge_21_30,
            mpm.charge_31_40,
            mpm.charge_41_50,
            mpm.charge_51_up,
            m.meters_id
        FROM meter_reading_tbl mrt
        INNER JOIN meters m ON mrt.meters_id = m.meters_id
        INNER JOIN concessionaires c ON m.concessionaires_id = c.concessionaires_id
        LEFT JOIN barangay_settings b ON c.home_barangay_id = b.barangay_id AND b.deleted = 0
        LEFT JOIN zonebook_settings z ON m.zonebook_id = z.zonebook_id
        INNER JOIN billing_schedule_settings bsst ON bsst.billing_schedule_id = mrt.billing_schedule_id
        LEFT JOIN meter_size_settings ms ON m.meter_size_id = ms.meter_size_id AND ms.deleted = 0
        LEFT JOIN classification_settings cs ON m.classification_id = cs.classification_id AND cs.deleted = 0
        LEFT JOIN manage_price_matrix mpm ON mpm.classification = cs.classification AND mpm.meter_size = ms.meter_size
        WHERE m.zonebook_id = ?
          AND mrt.billing_schedule_id = ?
          AND mrt.billed = 1
          AND m.deleted = 0
          AND c.deleted = 0
    ";

    $stmt = $con->prepare($sql);
    $stmt->bind_param('iii', $billing_schedule_id, $zonebook_id, $billing_schedule_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $previousReading = floatval($row['previous_reading'] ?? 0);
            $currentReading  = floatval($row['current_reading'] ?? 0);
            $consumed = max(0, $currentReading - $previousReading);

            $price         = floatval($row['minimum_price'] ?? 0);
            $charge_0      = floatval($row['charge_0'] ?? 0);
            $charge_11_20  = floatval($row['charge_11_20'] ?? 0);
            $charge_21_30  = floatval($row['charge_21_30'] ?? 0);
            $charge_31_40  = floatval($row['charge_31_40'] ?? 0);
            $charge_41_50  = floatval($row['charge_41_50'] ?? 0);
            $charge_51_up  = floatval($row['charge_51_up'] ?? 0);

            // ===================== Compute Base Amount =====================
            if ($consumed <= 10) {
                $amountDue = $price;
            } elseif ($consumed <= 20) {
                $amountDue = $price + (($consumed - $charge_0) * $charge_11_20);
            } elseif ($consumed <= 30) {
                $amountDue = $price + (($consumed - $charge_0) * $charge_21_30);
            } elseif ($consumed <= 40) {
                $amountDue = $price + (($consumed - $charge_0) * $charge_31_40);
            } elseif ($consumed <= 50) {
                $amountDue = $price + (($consumed - $charge_0) * $charge_41_50);
            } else {
                $amountDue = $price + (($consumed - $charge_0) * $charge_51_up);
            }

            // Initialize final amount
            $finalAmount = $amountDue;

            // ===================== Apply Discount =====================
            $discountDescription = $row['discount'] ?? '';
            $discountRate = 0;
            $discountAmount = 0;

            if (!empty($discountDescription)) {

                $stmtRate = $con->prepare("SELECT rate FROM rates WHERE description = ?");
                $stmtRate->bind_param("s", $discountDescription);
                $stmtRate->execute();
                $resultRate = $stmtRate->get_result();

                if ($resultRate->num_rows > 0) {
                    $rateRow = $resultRate->fetch_assoc();
                    $discountRate = floatval($rateRow['rate']);

                    $discountAmount = $amountDue * $discountRate;
                    $finalAmount = max(0, $amountDue - $discountAmount);
                }

                $stmtRate->close();
            }

            // ===================== Arrears =====================
            $arrears_stmt = $con->prepare("
                SELECT bsst.reading_date, mrt.reading AS current_reading
                FROM meter_reading_tbl mrt
                INNER JOIN billing_schedule_settings bsst
                    ON mrt.billing_schedule_id = bsst.billing_schedule_id
                WHERE mrt.meters_id = ?
                  AND mrt.billed = 0
                  AND mrt.deleted = 0
                  AND bsst.deleted = 0
                ORDER BY bsst.reading_date ASC
            ");

            $arrears_stmt->bind_param("i", $row['meters_id']);
            $arrears_stmt->execute();
            $arrears_result = $arrears_stmt->get_result();

            $arrears_display = [];

            while ($a = $arrears_result->fetch_assoc()) {

                $monthYear = date('F Y', strtotime($a['reading_date']));
                $arrears_display[] = $monthYear;
            }

            $arrears_stmt->close();

            $arrears_display_str = count($arrears_display)
                ? implode(', ', $arrears_display)
                : 'N/A';

            // =================== Build Data ===================
            $data[] = [
                'checkbox'         => '<input type="checkbox" class="rowCheckbox" data-id="'.$row['meter_reading_id'].'">',
                'account_no'       => $row['account_no'],
                'account_name'     => $row['account_name'],
                'barangay_name'    => $row['barangay_name'],
                'meter_no'         => $row['meter_no'],
                'zonebook'         => $row['zonebook'],
                'reading_date'     => date('F d, Y', strtotime($row['reading_date'])),
                'due_date'         => date('F d, Y', strtotime($row['date_due'])),
                'previous_reading' => number_format($previousReading, 2),
                'current_reading'  => number_format($currentReading, 2),
                'consumed'         => number_format($consumed, 2),
                'amount_due'       => '₱' . number_format($finalAmount, 2),
                'arrears'          => $arrears_display_str,
                'discount_name'    => $discountDescription ?: 'N/A',
                'discount_amount'  => $discountAmount > 0
                    ? '₱' . number_format($discountAmount, 2)
                    : 'N/A'
            ];
        }

        echo json_encode(['success' => true, 'data' => $data]);

    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No billed accounts found for the selected zone/book and billing schedule.'
        ]);
    }

    $stmt->close();

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$con->close();