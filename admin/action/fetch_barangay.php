<?php
require '../../db/dbconn.php';

$sql = "
    SELECT barangay
    FROM barangay_settings
    WHERE deleted = 0
    ORDER BY barangay ASC
";

$result = $con->query($sql);

$barangays = [];

while ($row = $result->fetch_assoc()) {
    $barangays[] = $row['barangay'];
}

echo json_encode($barangays);

$con->close();
?>