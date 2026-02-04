<?php
require '../../db/dbconn.php';

$account_no = isset($_POST['account_no']) ? $_POST['account_no'] : (isset($_GET['account_no']) ? $_GET['account_no'] : '');

$query = $con->prepare("
    SELECT 
        mrt.meter_reading_id, 
        mrt.description, 
        bsst.date_due, 
        pmt.price_per_cubic_meter, 
        mrt.consumed, 
        mst.account_no,
        CASE 
            WHEN mst.service_status_id = 1 THEN 'Connected'
            ELSE 'Disconnected'
        END AS service_status,
        CONCAT(cst.first_name, ' ', cst.last_name) AS account_name,
        acst.account_type, 
        csst.classification, 
        bst.barangay,
        (SELECT COUNT(*) FROM collection WHERE collection.meter_reading_id = mrt.meter_reading_id) AS collection_count
    FROM meter_reading_tbl mrt 
    INNER JOIN meters mst ON mst.meters_id = mrt.meters_id
    LEFT JOIN account_type_settings acst ON acst.account_type_id = mst.account_type_id
    LEFT JOIN classification_settings csst ON csst.classification_id = mst.classification_id
    INNER JOIN concessionaires cst ON cst.concessionaires_id = mst.concessionaires_id
    LEFT JOIN barangay_settings bst ON bst.barangay_id = cst.billing_barangay_id
    LEFT JOIN billing_schedule_settings bsst ON bsst.billing_schedule_id = mrt.billing_schedule_id
    LEFT JOIN price_matrix pmt ON pmt.classification_id = mst.classification_id 
        AND pmt.meter_size_id = mst.meter_size_id
    WHERE mst.account_no = ?
");

$query->bind_param("s", $account_no);
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

        // Determine if the bill has been collected
        $is_collected = $row['collection_count'] > 0;

        // Generate button based on collection status
        $button = $is_collected
            ? '<button class="btn btn-secondary btn-sm viewBillBtn" data-bill-id="'.$row['meter_reading_id'].'">View</button>'
            : '<button class="btn btn-primary btn-sm payBillBtn" data-bill-id="'.$row['meter_reading_id'].'">Pay</button>';

        $response['bills'][] = [
            "meter_reading_id" => $row['meter_reading_id'],
            "description" => $row['description'],
            "date_due" => date("F d, Y", strtotime($row['date_due'])),
            "consumed" => $row['consumed'],
            "price_per_cubic_meter" => $row['price_per_cubic_meter'],
            "amount" => number_format($amount, 2, '.', ''),
            "button" => $button
        ];
    }
}

echo json_encode($response);
?>