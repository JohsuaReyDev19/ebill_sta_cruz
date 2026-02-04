<?php
require '../../db/dbconn.php';

$account_no = isset($_POST['account_no']) ? $_POST['account_no'] : (isset($_GET['account_no']) ? $_GET['account_no'] : '');

$query = $con->prepare("
    SELECT 
        mrt.meter_reading_id, 
        mrt.description, 
        bsst.date_due, 
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
        ms.meter_size,

        mpm.minimum_price,
        mpm.charge_0,
        mpm.charge_11_20,
        mpm.charge_21_30,
        mpm.charge_31_40,
        mpm.charge_41_50,
        mpm.charge_51_up,

        (SELECT COUNT(*) 
         FROM collection 
         WHERE collection.meter_reading_id = mrt.meter_reading_id
        ) AS collection_count

    FROM meter_reading_tbl mrt 
    INNER JOIN meters mst 
        ON mst.meters_id = mrt.meters_id

    LEFT JOIN account_type_settings acst 
        ON acst.account_type_id = mst.account_type_id

    LEFT JOIN classification_settings csst 
        ON csst.classification_id = mst.classification_id
       AND csst.deleted = 0

    LEFT JOIN meter_size_settings ms
        ON ms.meter_size_id = mst.meter_size_id
       AND ms.deleted = 0

    INNER JOIN concessionaires cst 
        ON cst.concessionaires_id = mst.concessionaires_id

    LEFT JOIN barangay_settings bst 
        ON bst.barangay_id = cst.billing_barangay_id

    LEFT JOIN billing_schedule_settings bsst 
        ON bsst.billing_schedule_id = mrt.billing_schedule_id

    --  JOIN PRICE MATRIX
    LEFT JOIN manage_price_matrix mpm
        ON mpm.classification = csst.classification
       AND mpm.meter_size = ms.meter_size

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
        $consumed = floatval($row['consumed']);
        $charge_0 = floatval($row['charge_0']);
        $price        = floatval($row['minimum_price'] ?? 0);
        $charge_11_20 = floatval($row['charge_11_20'] ?? 0);
        $charge_21_30 = floatval($row['charge_21_30'] ?? 0);
        $charge_31_40 = floatval($row['charge_31_40'] ?? 0);
        $charge_41_50 = floatval($row['charge_41_50'] ?? 0);
        $charge_51_up = floatval($row['charge_51_up'] ?? 0);

        if ($consumed <= 10) {

            $amountDue = $price;

        } elseif ($consumed >= 11 && $consumed <= 20) {

            $amountDue = $price + (($consumed - $charge_0) * $charge_11_20);

        } elseif ($consumed >= 21 && $consumed <= 30) {

            $amountDue = $price + (($consumed - $charge_0) * $charge_21_30);

        } elseif ($consumed >= 31 && $consumed <= 40) {

            $amountDue = $price + (($consumed - $charge_0) * $charge_31_40);

        } elseif ($consumed >= 41 && $consumed <= 50) {

            $amountDue = $price + (($consumed - $charge_0) * $charge_41_50);

        } else {

            $amountDue = $price + (($consumed - $charge_0) * $charge_51_up);
        }


        // Determine if the bill has been collected
        $is_collected = $row['collection_count'] > 0;

        // Generate button based on collection status
        $button = $is_collected
            ? '<button class="btn btn-secondary btn-sm viewBillBtn" data-bill-id="'.$row['meter_reading_id'].'">View</button>'
            : '<button class="btn btn-primary btn-sm payBillBtn" data-bill-id="'.$row['meter_reading_id'].'">Pay</button>';

        $response['bills'][] = [
    "meter_reading_id" => $row['meter_reading_id'],
    "description"     => $row['description'],
    "date_due"        => date("F d, Y", strtotime($row['date_due'])),
    "consumed"        => number_format($consumed, 2),
    "amount"          => number_format($amountDue, 2, '.', ''),
    "button"          => $button
];

    }
}

echo json_encode($response);
?>