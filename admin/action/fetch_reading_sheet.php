<?php
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['zonebook_id'], $_POST['billing_schedule_id'])
) {

    $zonebook_id          = (int) $_POST['zonebook_id'];
    $billing_schedule_id  = (int) $_POST['billing_schedule_id'];
    $show_billed          = isset($_POST['show_billed']) && $_POST['show_billed'] == 1;

    /* =========================
       BILLED READINGS
    ========================== */
    if ($show_billed) {

        $sql = "
            SELECT 
                m.meters_id,
                m.account_no,
                c.first_name,
                c.last_name,
                m.meter_no,
                COALESCE(z.zonebook, 'Unassigned') AS zonebook,
                COALESCE(b.barangay, 'N/A') AS barangay_name,

                r.meter_reading_id,
                r.reading AS current_reading,
                r.consumed,
                r.reading_date,

                (
                    SELECT r2.reading
                    FROM meter_reading_tbl r2
                    WHERE r2.meters_id = m.meters_id
                      AND r2.billing_schedule_id < ?
                      AND r2.deleted = 0
                    ORDER BY r2.reading_date DESC
                    LIMIT 1
                ) AS previous_reading

            FROM meters m
            INNER JOIN concessionaires c 
                ON m.concessionaires_id = c.concessionaires_id
            LEFT JOIN zonebook_settings z 
                ON m.zonebook_id = z.zonebook_id
            LEFT JOIN barangay_settings b 
                ON c.home_barangay_id = b.barangay_id
                AND b.deleted = 0
            INNER JOIN meter_reading_tbl r 
                ON r.meters_id = m.meters_id
                AND r.billing_schedule_id = ?
                AND r.billed = 1
                AND r.deleted = 0

            WHERE m.zonebook_id = ?
              AND m.bill = 0
              AND c.deleted = 0
        ";

        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            'iii',
            $billing_schedule_id,
            $billing_schedule_id,
            $zonebook_id
        );

    /* =========================
       UNBILLED READINGS
    ========================== */
    } else {

        $sql = "
            SELECT 
                m.meters_id,
                m.account_no,
                c.first_name,
                c.last_name,
                m.meter_no,
                COALESCE(z.zonebook, 'Unassigned') AS zonebook,
                COALESCE(b.barangay, 'N/A') AS barangay_name,

                NULL AS meter_reading_id,
                NULL AS current_reading,
                0    AS consumed,
                NULL AS reading_date,

                (
                    SELECT r.reading
                    FROM meter_reading_tbl r
                    WHERE r.meters_id = m.meters_id
                      AND r.deleted = 0
                    ORDER BY r.reading_date DESC
                    LIMIT 1
                ) AS previous_reading

            FROM meters m
            INNER JOIN concessionaires c 
                ON m.concessionaires_id = c.concessionaires_id
            LEFT JOIN zonebook_settings z 
                ON m.zonebook_id = z.zonebook_id
            LEFT JOIN barangay_settings b 
                ON c.home_barangay_id = b.barangay_id
                AND b.deleted = 0

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
        $stmt->bind_param(
            'ii',
            $zonebook_id,
            $billing_schedule_id
        );
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data   = [];

    while ($row = $result->fetch_assoc()) {

        $metersId = (int) $row['meters_id'];
        $isBilled = $show_billed;

        $previous = (float) ($row['previous_reading'] ?? 0);
        $current  = (float) ($row['current_reading'] ?? 0);
        $consumed = (float) ($row['consumed'] ?? 0);
        
        $currentDate = date('M d, Y');

        $readingDate = $row['reading_date']
            ? date('M d, Y', strtotime($row['reading_date']))
            : $currentDate;

        /* =========================
           INPUT + ACTIONS
        ========================== */
        if ($isBilled) {

        // SAFETY: meter_reading_id must exist
            if ($row['meter_reading_id'] === null) {
                continue;
            }

            $currentReadingInput = '
                <input type="number"
                    class="form-control-plaintext current-reading"
                    value="'.htmlspecialchars($current).'"
                    data-prev="'.htmlspecialchars($previous).'"
                    disabled>';

            $action = '
                <div class="bill-actions">
                    <button class="btn btn-sm btn-info update-bill"
                            data-account="'.$metersId.'"
                            data-reading-id="'.$row['meter_reading_id'].'">
                        Update
                    </button>

                    <button class="btn btn-sm btn-primary regenerate-bill d-none"
                            data-account="'.$metersId.'"
                            data-reading-id="'.$row['meter_reading_id'].'">
                        Update Bill
                    </button>

                    <button class="btn btn-sm btn-secondary cancel-update d-none">
                        Cancel
                    </button>
                </div>';

        } else {

            $currentReadingInput = '
                <input type="number"
                       class="border current-reading border-primary"
                       data-account="'.$metersId.'"
                       style="padding:2px;height:30px;text-align:center;width:70px;">';

            $action = '
                <button class="btn btn-sm btn-primary generate-bill"
                        data-account="'.$metersId.'">
                    Bill
                </button>';
        }

        $data[] = [
            'checkbox'         => '<input type="checkbox" '.($isBilled ? 'disabled' : '').'>',
            'account_no'       => $row['account_no'],
            'account_name'     => $row['last_name'].', '.$row['first_name'],
            'barangay_name'    => $row['barangay_name'],
            'meter_no'         => $row['meter_no'],
            'zonebook'         => $row['zonebook'],
            'previous_reading' => number_format($previous, 2),
            'current_reading'  => $currentReadingInput,
            'consumed'         => number_format($consumed, 2),
            'reading_date'     => $readingDate,
            'action'           => $action
        ];
    }

    echo json_encode([
        'success' => true,
        'data'    => $data
    ]);
}
