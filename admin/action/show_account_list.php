<?php
require '../../db/dbconn.php';
require '../../config.php';

$draw   = intval($_POST['draw'] ?? 1);
$start  = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 10);
$search = $_POST['search']['value'] ?? '';

$searchSql = '';
$params = [];

if (!empty($search)) {
    $searchSql = " AND (
        m.account_no LIKE ? OR
        ct.institution_name LIKE ? OR
        CONCAT(ct.last_name, ', ', ct.first_name, ' ', ct.middle_name) LIKE ? OR
        ats.account_type LIKE ? OR
        m.meter_no LIKE ? OR
        cs.classification LIKE ?
    )";

    for ($i = 0; $i < 6; $i++) {
        $params[] = "%$search%";
    }
}

$query = "
    SELECT 
        m.meters_id,
        m.account_no,
        CASE 
            WHEN ct.is_institution = 1 THEN ct.institution_name
            ELSE CONCAT(ct.last_name, ', ', ct.first_name, ' ', ct.middle_name)
        END AS account_name,
        ats.account_type,
        m.meter_no,
        CONCAT(ms.meter_size, ' ', mb.meter_brand) AS meter,
        cs.classification
    FROM meters m
    INNER JOIN concessionaires ct ON ct.concessionaires_id = m.concessionaires_id
    INNER JOIN account_type_settings ats ON ats.account_type_id = m.account_type_id
    INNER JOIN classification_settings cs ON cs.classification_id = m.classification_id
    INNER JOIN meter_size_settings ms ON ms.meter_size_id = m.meter_size_id
    INNER JOIN meter_brand_settings mb ON mb.meter_brand_id = m.meter_brand_id
    WHERE m.deleted = 0 AND ct.deleted = 0
    $searchSql
    ORDER BY m.meters_id ASC
    LIMIT ?, ?
";

$params[] = $start;
$params[] = $length;

$stmt = $con->prepare($query);
$types = str_repeat('s', count($params) - 2) . 'ii';
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
$counter = $start + 1;

while ($row = $result->fetch_assoc()) {
    $encryptedId = urlencode(openssl_encrypt(
        $row['meters_id'],
        'aes-256-cbc',
        $encryptionKey,
        0,
        $iv
    ));

    $data[] = [
        $counter++,
        $row['account_no'],
        htmlspecialchars($row['account_name']),
        $row['account_type'],
        $row['meter_no'],
        $row['meter'],
        $row['classification'],
        '<a href="edit-meter.php?id=' . $encryptedId . '" class="btn btn-sm btn-primary">Edit</a>
         <button class="btn btn-sm btn-danger delete-meter-btn" data-id="' . $encryptedId . '">Delete</button>'
    ];
}

$totalRecords = $con->query("
    SELECT COUNT(*) total FROM meters m WHERE m.deleted = 0
")->fetch_assoc()['total'];

$totalFiltered = $totalRecords;

if (!empty($search)) {
    $countStmt = $con->prepare("
        SELECT COUNT(*) total
        FROM meters m
        INNER JOIN concessionaires ct ON ct.concessionaires_id = m.concessionaires_id
        INNER JOIN account_type_settings ats ON ats.account_type_id = m.account_type_id
        INNER JOIN classification_settings cs ON cs.classification_id = m.classification_id
        WHERE m.deleted = 0 AND ct.deleted = 0 $searchSql
    ");
    $countStmt->bind_param(str_repeat('s', 6), ...array_slice($params, 0, 6));
    $countStmt->execute();
    $totalFiltered = $countStmt->get_result()->fetch_assoc()['total'];
}

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
]);

$con->close();
