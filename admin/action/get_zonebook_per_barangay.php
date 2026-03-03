<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');

$barangay_id = $_POST['barangay_id'] ?? '';

if (!$barangay_id) {
    echo json_encode([]);
    exit;
}

// Get zones assigned to the selected barangay
$sql = "
    SELECT z.zonebook_id, z.zonebook
    FROM zonebook_barangay zb
    JOIN zonebook_settings z ON zb.zonebook_id = z.zonebook_id
    WHERE zb.barangay_id = ? AND zb.deleted = 0 AND z.deleted = 0
    ORDER BY z.zonebook ASC
";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $barangay_id);
$stmt->execute();
$result = $stmt->get_result();

$zones = [];
while ($row = $result->fetch_assoc()) {
    $zones[] = $row;
}

echo json_encode($zones);