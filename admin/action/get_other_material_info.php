<?php
require '../../db/dbconn.php';

$response = ['success' => false];

if (isset($_GET['material']) && !empty($_GET['material'])) {
    $material = mysqli_real_escape_string($con, $_GET['material']);

    $query = "SELECT units, price_per_units 
              FROM other_billing_material_pricing_settings 
              WHERE other_billing_material = '$material' AND deleted = 0 
              LIMIT 1";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response = [
            'success' => true,
            'units' => $row['units'],
            'price_per_units' => number_format($row['price_per_units'], 2)
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
