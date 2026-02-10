<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');
error_reporting(0); // prevent warnings from breaking JSON

$meter_reading_id = isset($_POST['bill_id']) ? $_POST['bill_id'] : '';

if (!$meter_reading_id) {
    echo json_encode([
        "success" => false,
        "message" => "No Bill ID provided."
    ]);
    exit;
}

// Fetch meter reading and account info
$query = $con->prepare("
    SELECT 
        mrt.meter_reading_id, 
        mrt.description, 
        bsst.date_due, 
        mrt.consumed, 
        mst.account_no, 
        CONCAT(cst.first_name, ' ', cst.last_name) AS account_name, 
        cst.discount,
        ssst.service_status, 
        acst.account_type, 
        csst.classification, 
        bst.barangay,
        col.amount_paid,
        col.amount_change,
        col.payment_date,
        msst.meter_size,

        --  PRICE MATRIX
        mpm.minimum_price,
        mpm.charge_11_20,
        mpm.charge_21_30,
        mpm.charge_31_40,
        mpm.charge_41_50,
        mpm.charge_51_up

    FROM meter_reading_tbl mrt 
    INNER JOIN meters mst 
        ON mst.meters_id = mrt.meters_id

    LEFT JOIN meter_size_settings msst 
        ON msst.meter_size_id = mst.meter_size_id
       AND msst.deleted = 0

    LEFT JOIN service_status_settings ssst 
        ON ssst.service_status_id = mst.service_status_id

    LEFT JOIN account_type_settings acst 
        ON acst.account_type_id = mst.account_type_id

    LEFT JOIN classification_settings csst 
        ON csst.classification_id = mst.classification_id
       AND csst.deleted = 0

    LEFT JOIN concessionaires cst 
        ON cst.concessionaires_id = mst.concessionaires_id

    LEFT JOIN barangay_settings bst 
        ON bst.barangay_id = cst.billing_barangay_id

    LEFT JOIN billing_schedule_settings bsst 
        ON bsst.billing_schedule_id = mrt.billing_schedule_id

    -- JOIN PRICE MATRIX
    LEFT JOIN manage_price_matrix mpm
        ON mpm.classification = csst.classification
       AND mpm.meter_size = msst.meter_size

    LEFT JOIN collection col 
        ON col.meter_reading_id = mrt.meter_reading_id

    WHERE mrt.meter_reading_id = ?
");


$query->bind_param("i", $meter_reading_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Bill not found."
    ]);
    exit;
}

$row = $result->fetch_assoc();

$consumed = floatval($row['consumed']);

$price        = floatval($row['minimum_price'] ?? 0);
$charge_11_20 = floatval($row['charge_11_20'] ?? 0);
$charge_21_30 = floatval($row['charge_21_30'] ?? 0);
$charge_31_40 = floatval($row['charge_31_40'] ?? 0);
$charge_41_50 = floatval($row['charge_41_50'] ?? 0);
$charge_51_up = floatval($row['charge_51_up'] ?? 0);

if ($consumed <= 10) {

    $amountDue = $price;

} elseif ($consumed >= 11 && $consumed <= 20) {

    $amountDue = $price + (($consumed - 10) * $charge_11_20);

} elseif ($consumed >= 21 && $consumed <= 30) {

    $amountDue = $price +  (($consumed - 10) * $charge_21_30);

} elseif ($consumed >= 31 && $consumed <= 40) {

    $amountDue = $price + (($consumed - 10) * $charge_31_40);

} elseif ($consumed >= 41 && $consumed <= 50) {

    $amountDue = $price + (($consumed - 10) * $charge_41_50);

} else {

    $amountDue = $price + (($consumed - 10) * $charge_51_up);
}


        $amount = $amountDue; 
        $discountRate = 0;
        $discountAmount = 0;
        $finalAmount = $amount;
        $discount = "";
        if (!empty($row['discount'])) {

            $stmtRate = $con->prepare("SELECT rate FROM rates WHERE description = ?");
            $stmtRate->bind_param("s", $row['discount']);
            $stmtRate->execute();
            $resultRate = $stmtRate->get_result();

            if ($resultRate->num_rows > 0) {
                $rateRow = $resultRate->fetch_assoc();
                $discountRate = (float)$rateRow['rate'];
                $discount = $discountRate;
                $discountAmount = $amount * $discountRate;
                
                $finalAmount = $amount - $discountAmount;
            }
        }


// Prepare JSON response
$response = [
    "success" => true,
    "account" => [
        "account_no" => $row['account_no'],
        "account_name" => $row['account_name'],
        "service_status" => $row['service_status'],
        "account_type" => $row['account_type'],
        "classification" => $row['classification'],
        "barangay" => $row['barangay']
    ],
    "bills" => [
        [
            "meter_reading_id" => $row['meter_reading_id'],
            "description" => $row['description'],
            "date_due" => date("F d, Y", strtotime($row['date_due'])),
            "consumed" => number_format($consumed, 2),
            "totalAmount" => number_format($amountDue, 2, '.', ''), // 
            "discountAmount" => number_format($discountAmount, 2, '.', ''), //
            "amount" => number_format($finalAmount, 2, '.', ''),
            "amount_paid" => number_format($row['amount_paid'] ?? 0, 2, '.', ''),
            "amount_change" => number_format($row['amount_change'] ?? 0, 2, '.', ''),
            "payment_date" => $row['payment_date']
                ? date("F d, Y", strtotime($row['payment_date']))
                : "Not Paid"
        ]
    ]
];


echo json_encode($response);
exit;
?>
