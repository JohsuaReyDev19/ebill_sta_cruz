<?php
require '../../db/dbconn.php';

$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
$meters_id = isset($_POST['meters_id']) ? $_POST['meters_id'] : '';

if (empty($meters_id)) {
    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => []
    ]);
    exit;
}

// Get total records
$totalQuery = $con->prepare("SELECT COUNT(*) FROM other_billing ob
    INNER JOIN meters m ON m.meters_id = ob.meters_id
    WHERE m.meters_id = ?");
$totalQuery->bind_param("s", $meters_id);
$totalQuery->execute();
$totalQuery->bind_result($recordsTotal);
$totalQuery->fetch();
$totalQuery->close();

// Get filtered data
$searchClause = $searchValue ? " AND (ob.description LIKE ? OR ob.remarks LIKE ?)" : "";
$sql = "SELECT ob.other_billing_id, ob.units_included, ob.description, ob.remarks,
            ob.amount_due, ob.billing_date, ob.billed, m.account_no, ob.due_date, billed
        FROM other_billing ob
        INNER JOIN meters m ON m.meters_id = ob.meters_id
        WHERE m.meters_id = ? $searchClause
        ORDER BY ob.billing_date DESC
        LIMIT ?, ?";
$query = $con->prepare($sql);

if ($searchValue) {
    $like = "%$searchValue%";
    $query->bind_param("sssii", $meters_id, $like, $like, $start, $length);
} else {
    $query->bind_param("sii", $meters_id, $start, $length);
}

$query->execute();
$result = $query->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $is_collected = $row['billed'] === 0;
    $button = $is_collected
        ? '<button class="btn btn-primary btn-sm shadow-sm billBtn" data-bill-id="' . $row['other_billing_id'] . '">Bill</button>'
        : '<button class="btn btn-secondary btn-sm shadow-sm viewBillBtn" data-bill-id="' . $row['other_billing_id'] . '">View</button>';
    $billed_status = $is_collected ? '<span class="badge badge-pill badge-secondary">Not Billed</span>' : '<span class="badge badge-pill badge-success">Billed</span>';
    $is_due_date_set = $row["due_date"] === "0000-00-00";
    $due_date = $is_due_date_set ? 'No Due Date Set' : date("F d, Y", strtotime($row['due_date']));

    $data[] = [
        $row['other_billing_id'],                             // 0 - Bill No
        $row['description'],                                  // 1 - Description
        $row['units_included'],                               // 2 - Units Included
        $row['remarks'],                                      // 3 - Remarks
        '₱' . number_format($row['amount_due'], 2),           // 4 - Amount Due
        $due_date,                                            // 5 - Due Date
        $billed_status,                                       // 6 - Status
        $button,                                              // 7 - Action
        date("F d, Y", strtotime($row['billing_date'])),      // 8 - Billing Date
    ];
}

// Fetch account info
$accountQuery = $con->prepare("
    SELECT 
        m.account_no,
        CONCAT(c.first_name, ' ', c.last_name) AS account_name,
        CASE 
            WHEN m.service_status_id = 1 THEN 'Connected'
            ELSE 'Disconnected'
        END AS service_status,
        at.account_type,
        cl.classification,
        b.barangay
    FROM meters m
    INNER JOIN concessionaires c ON c.concessionaires_id = m.concessionaires_id
    LEFT JOIN account_type_settings at ON at.account_type_id = m.account_type_id
    LEFT JOIN classification_settings cl ON cl.classification_id = m.classification_id
    LEFT JOIN barangay_settings b ON b.barangay_id = c.billing_barangay_id
    WHERE m.meters_id = ?
");
$accountQuery->bind_param("s", $meters_id);
$accountQuery->execute();
$accountResult = $accountQuery->get_result();
$accountInfo = $accountResult->fetch_assoc();
$accountQuery->close();

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,
    "recordsFiltered" => $recordsTotal,
    "data" => $data, // for DataTables
    "bills" => array_map(function($row) {
        return [
            "other_billing_id" => $row[0],
            "description" => $row[1],
            "units_included" => $row[2],
            "remarks" => $row[3],
            "amount_due" => floatval(str_replace(['₱', ','], '', $row[4])),
            "billing_date" => $row[8],
            "due_date" => $row[5],
            "billed_status" => $row[6]
        ];
    }, $data),
    "account" => $accountInfo
]);


