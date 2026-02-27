<?php
require '../../db/dbconn.php';

$metersId = intval($_POST['meters_id']);

$query = "SELECT * FROM other_billing
          WHERE meters_id = '$metersId'
          AND billed = 0
          AND deleted = 0";

$result = mysqli_query($con, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "hasOtherBilling" => count($data) > 0,
    "data" => $data
]);