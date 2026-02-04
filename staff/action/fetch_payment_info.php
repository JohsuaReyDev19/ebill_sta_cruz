<?php
require '../../db/dbconn.php'; // Adjust if needed

$meter_reading_id = isset($_POST['bill_id']) ? $_POST['bill_id'] : (isset($_GET['bill_id']) ? $_GET['bill_id'] : '');

$query = $con->prepare("
    SELECT 
        mrt.meter_reading_id, 
        mrt.description, 
        bsst.date_due, 
        pmt.price_per_cubic_meter, 
        mrt.consumed, 
        mst.account_no, 
        CONCAT(cst.first_name, ' ', cst.last_name) AS account_name, 
        ssst.service_status, 
        acst.account_type, 
        csst.classification, 
        bst.barangay,
        col.amount_paid,
        col.amount_change,
        col.payment_date
    FROM meter_reading_tbl mrt 
    INNER JOIN meters mst ON mst.meters_id = mrt.meters_id
    LEFT JOIN service_status_settings ssst ON ssst.service_status_id = mst.service_status_id
    LEFT JOIN account_type_settings acst ON acst.account_type_id = mst.account_type_id
    LEFT JOIN classification_settings csst ON csst.classification_id = mst.classification_id
    INNER JOIN concessionaires cst ON cst.concessionaires_id = mst.concessionaires_id
    LEFT JOIN barangay_settings bst ON bst.barangay_id = cst.billing_barangay_id
    LEFT JOIN billing_schedule_settings bsst ON bsst.billing_schedule_id = mrt.billing_schedule_id
    LEFT JOIN price_matrix pmt ON pmt.classification_id = mst.classification_id 
        AND pmt.meter_size_id = mst.meter_size_id
    LEFT JOIN collection col ON col.meter_reading_id = mrt.meter_reading_id
    WHERE mrt.meter_reading_id = ?
");

$query->bind_param("s", $meter_reading_id);
$query->execute();
$result = $query->get_result();

$response = ["success" => false, "message" => "No records found"];

if ($result->num_rows > 0) {
    $response = [
        "success" => true,
        "account" => [],
        "bills" => []
    ];

    while ($row = $result->fetch_assoc()) {
        // Set account details only once
        if (empty($response['account'])) {
            $response["account"] = [
                "account_no" => $row['account_no'],
                "account_name" => $row['account_name'],
                "service_status" => $row['service_status'],
                "account_type" => $row['account_type'],
                "classification" => $row['classification'],
                "barangay" => $row['barangay']
            ];
        }

        // Compute bill amount
        $consumed = $row['consumed'];
        $base_price = $row['price_per_cubic_meter'];
        $amount = 0;

        if ($consumed <= 10) {
            $amount = $base_price;
        } elseif ($consumed <= 20) {
            $amount = $consumed * 18.15;
        } elseif ($consumed <= 30) {
            $amount = $consumed * 19.40;
        } elseif ($consumed <= 40) {
            $amount = $consumed * 20.65;
        } elseif ($consumed <= 50) {
            $amount = $consumed * 22.00;
        } else {
            $amount = $consumed * 23.45;
        }

        $response['bills'][] = [
            "meter_reading_id" => $row['meter_reading_id'],
            "description" => $row['description'],
            "date_due" => date("F d, Y", strtotime($row['date_due'])),
            "consumed" => $row['consumed'],
            "price_per_cubic_meter" => $row['price_per_cubic_meter'],
            "amount" => number_format($amount, 2, '.', ''),
            "amount_paid" => number_format($row['amount_paid'], 2, '.', ''),
            "amount_change" => number_format($row['amount_change'], 2, '.', ''),
            "payment_date" => $row['payment_date'] ? date("F d, Y", strtotime($row['payment_date'])) : "Not Paid"
        ];
    }
}

echo json_encode($response);
?>
