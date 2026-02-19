<?php
header('Content-Type: application/json');
require '../../db/dbconn.php';

$meterReadingIds = $_POST['meter_ids'] ?? [];
$readingDate     = $_POST['reading_date'] ?? date('Y-m-d');

$data = [];

foreach ($meterReadingIds as $reading_id) {

    // 1️⃣ Get main reading + meter info
    $stmt = $con->prepare("
        SELECT 
            mr.meter_reading_id,
            mr.reading,
            mr.consumed,
            mr.reading_date,
            m.meters_id,
            m.account_no,
            m.meter_no,
            b.barangay,
            c.concessionaire_name
        FROM meter_reading_tbl mr
        INNER JOIN meters m ON mr.meters_id = m.meters_id
        LEFT JOIN barangay_settings b ON m.barangay_id = b.barangay_id
        LEFT JOIN concessionaires c ON m.concessionaires_id = c.concessionaires_id
        WHERE mr.meter_reading_id = ?
        LIMIT 1
    ");

    $stmt->bind_param("i", $reading_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $acc = $result->fetch_assoc();

    if (!$acc) continue;

    // 2️⃣ Compute previous reading
    $previousReading = $acc['reading'] - $acc['consumed'];

    // 3️⃣ Fetch arrears (all unpaid BEFORE current billing date)
    $stmt3 = $con->prepare("
        SELECT 
            mr.reading_date,
            COALESCE(col.amount_due, 0) AS amount_due
        FROM meter_reading_tbl mr
        LEFT JOIN collection col 
            ON mr.meter_reading_id = col.meter_reading_id
        WHERE mr.meters_id = ?
        AND mr.billed = 0
        AND mr.deleted = 0
        AND mr.reading_date < ?
        ORDER BY mr.reading_date ASC
    ");

    $stmt3->bind_param("is", $acc['meters_id'], $readingDate);
    $stmt3->execute();
    $res3 = $stmt3->get_result();

    $arrears = [];

    while ($row = $res3->fetch_assoc()) {
        $monthYear = date("F Y", strtotime($row['reading_date']));
        $amountDue = number_format($row['amount_due'], 2);
        $arrears[] = "$monthYear (₱$amountDue)";
    }

    $arrearsStr = !empty($arrears) ? implode(", ", $arrears) : "---";

    // 4️⃣ Compute current bill
    $rate = 170;
    $amountDue = $acc['consumed'] * $rate;

    $data[] = [
        "account_no"       => $acc['account_no'],
        "account_name"     => $acc['concessionaire_name'],
        "barangay"         => $acc['barangay'],
        "meter_no"         => $acc['meter_no'],
        "previous_reading" => number_format($previousReading, 2),
        "current_reading"  => number_format($acc['reading'], 2),
        "consumed"         => number_format($acc['consumed'], 2),
        "amount_due"       => "₱" . number_format($amountDue, 2),
        "arrears"          => $arrearsStr
    ];
}

echo json_encode($data);
