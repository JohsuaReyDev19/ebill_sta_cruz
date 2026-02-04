<?php
require '../../db/dbconn.php';
include '../function/formatFractionString.php';

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $concessionaires_id = mysqli_real_escape_string($con, $_POST['concessionaires_id']);
    $account_no = mysqli_real_escape_string($con, $_POST['account_no']);
    $account_type = mysqli_real_escape_string($con, $_POST['account_type']);
    $classification = mysqli_real_escape_string($con, $_POST['classification']);
    $meter_no = mysqli_real_escape_string($con, $_POST['meter_no']);
    $meter_size_id = mysqli_real_escape_string($con, $_POST['meter_size']);
    $meter_brand_id = mysqli_real_escape_string($con, $_POST['meter_brand']);
    $zonebook = mysqli_real_escape_string($con, $_POST['zonebook']);
    $date_applied = mysqli_real_escape_string($con, $_POST['date_applied']);
    $billing_date = date('Y-m-d');

    if (empty($account_no) || empty($meter_no) || empty($meter_size_id) || empty($meter_brand_id)) {
        $response = ["status" => "error", "message" => "Required fields are missing."];
    } else {
        // Insert new meter record
        $insert_meter_sql = "INSERT INTO meters (
            concessionaires_id, account_no, account_type_id, classification_id, meter_no, 
            meter_size_id, meter_brand_id, zonebook_id, date_applied, service_status_id
        ) VALUES (
            '$concessionaires_id', '$account_no', '$account_type', '$classification', '$meter_no',
            '$meter_size_id', '$meter_brand_id', '$zonebook', '$date_applied', 0
        )";

        if (mysqli_query($con, $insert_meter_sql)) {
            $new_meters_id = mysqli_insert_id($con); // Get the newly inserted meter ID

            // Fetch meter size info
            $meter_size_query = mysqli_query($con, "SELECT meter_size, unit_price FROM meter_size_settings WHERE meter_size_id = '$meter_size_id'");
            $meter_size_row = mysqli_fetch_assoc($meter_size_query);
            $meter_size_label = formatFractionString($meter_size_row['meter_size']);
            $unit_price = floatval($meter_size_row['unit_price']);

            // Fetch meter brand
            $meter_brand_query = mysqli_query($con, "SELECT meter_brand FROM meter_brand_settings WHERE meter_brand_id = '$meter_brand_id'");
            $meter_brand_row = mysqli_fetch_assoc($meter_brand_query);
            $meter_brand = $meter_brand_row['meter_brand'];

            $units_included = "$meter_brand $meter_size_label";
            $amount_due = $unit_price;
            $description = "Opening of new account with meter $units_included";

            // Insert initial billing
            $insert_billing_sql = "INSERT INTO other_billing (
                meters_id,
                units_included,
                price_per_units,
                quantity,
                amount_due,
                remarks,
                description,
                billing_date,
                billed
            ) VALUES (
                '$new_meters_id',
                '$units_included',
                '$unit_price',
                1,
                '$amount_due',
                'New meter account setup',
                '$description',
                '$billing_date',
                0
            )";

            if (mysqli_query($con, $insert_billing_sql)) {
                $response = [
                    "status" => "success",
                    "message" => "New account and charges recorded.",
                    "meters_id" => $new_meters_id // return this for AJAX
                ];
            } else {
                $response = [
                    "status" => "error",
                    "message" => "Account created, but billing failed: " . mysqli_error($con)
                ];
            }
        } else {
            $response = ["status" => "error", "message" => "Failed to create account: " . mysqli_error($con)];
        }
    }
} else {
    $response = ["status" => "error", "message" => "Invalid request."];
}

header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($con);
