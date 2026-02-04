<?php
require '../../db/dbconn.php';

$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$start = isset($_POST['start']) ? max(0, intval($_POST['start'])) : 0;
$length = isset($_POST['length']) && intval($_POST['length']) > 0 ? intval($_POST['length']) : 10;
$meters_id = isset($_POST['meters_id']) ? intval($_POST['meters_id']) : 0;

$data = [];

if ($meters_id > 0) {
    // Count total records
    $totalQuery = "SELECT COUNT(*) AS total FROM other_billing WHERE meters_id = $meters_id";
    $totalResult = mysqli_query($con, $totalQuery);
    $total = mysqli_fetch_assoc($totalResult)['total'] ?? 0;

    // Fetch paginated data
    $query = "
        SELECT units_included, quantity, price_per_units, description, amount_due, billing_date, billed 
        FROM other_billing 
        WHERE meters_id = $meters_id 
        ORDER BY billing_date DESC 
        LIMIT $start, $length
    ";

    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['billed'] == 1) {
            $billing_status = '<span class="badge badge-pill badge-success">Billed</span>';
        } else {
            $billing_status = '<span class="badge badge-pill badge-secondary">Not Billed</span>';
        }

        $data[] = [
            "units_included" => "<small>" . $row['units_included'] . "</small>",
            "description" => "<small>" . $row['description'] . "</small>",
            "unit_price" => "₱" . number_format($row['price_per_units'], 2),
            "quantity" => $row['quantity'],
            "subtotal" => "₱" . number_format($row['amount_due'], 2),
            "billing_date" => date("M j, Y", strtotime($row['billing_date'])),
            "billing_status" => $billing_status
        ];
    }

    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => $total,
        "recordsFiltered" => $total,
        "data" => $data
    ]);
} else {
    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => []
    ]);
}
