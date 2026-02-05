<?php
require '../../db/dbconn.php';
include '../function/formatFractionString.php';

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $concessionaires_id = mysqli_real_escape_string($con, $_POST['concessionaires_id']);
    $account_type = mysqli_real_escape_string($con, $_POST['account_type']);
    $classification = mysqli_real_escape_string($con, $_POST['classification']);
    $meter_no = mysqli_real_escape_string($con, $_POST['meter_no']);
    $meter_size_id = mysqli_real_escape_string($con, $_POST['meter_size']);
    $meter_brand_id = mysqli_real_escape_string($con, $_POST['meter_brand']);
    $zonebook_id = mysqli_real_escape_string($con, $_POST['zonebook']);
    $date_applied = mysqli_real_escape_string($con, $_POST['date_applied']);
    $billing_date = date('Y-m-d');

    // Required fields check
    if (empty($meter_no) || empty($meter_size_id) || empty($meter_brand_id) || empty($zonebook_id) || empty($account_type) || empty($classification)) {
        $response = ["status" => "error", "message" => "Required fields are missing."];
    } else {
        

        // 1️⃣ Get Zone Code (3 digits)
        $zoneQuery = mysqli_query($con, "SELECT zonebook FROM zonebook_settings WHERE zonebook_id = '$zonebook_id'");
        $zoneRow = mysqli_fetch_assoc($zoneQuery);
        $zoneCode = str_pad($zoneRow['zonebook'], 3, '0', STR_PAD_LEFT);

        // 2️⃣ Get Meter Size Code (2 digits)
        $meterQuery = mysqli_query($con, "SELECT meter_size FROM meter_size_settings WHERE meter_size_id = '$meter_size_id'");
        $meterRow = mysqli_fetch_assoc($meterQuery);
        $meterCode = str_pad($meterRow['meter_size'], 2, '0', STR_PAD_LEFT);

        // 3️⃣ Get last series
        $likePattern = "$zoneCode-$meterCode-%";
        $seriesQuery = mysqli_query($con, "SELECT account_no FROM meters WHERE account_no LIKE '$likePattern' ORDER BY account_no DESC LIMIT 1");

        if (mysqli_num_rows($seriesQuery) > 0) {
            $last = mysqli_fetch_assoc($seriesQuery);
            $lastSeries = intval(substr($last['account_no'], -3));
            $newSeries = $lastSeries + 1;
        } else {
            $newSeries = 1;
        }

        $seriesCode = str_pad($newSeries, 3, '0', STR_PAD_LEFT);

        $account_no = "$zoneCode-$meterCode-$seriesCode";

        // -------------------------------
        // Insert new meter record
        // -------------------------------
        $insert_meter_sql = "INSERT INTO meters (
            concessionaires_id, account_no, account_type_id, classification_id, meter_no, 
            meter_size_id, meter_brand_id, zonebook_id, date_applied, service_status_id
        ) VALUES (
            '$concessionaires_id', '$account_no', '$account_type', '$classification', '$meter_no',
            '$meter_size_id', '$meter_brand_id', '$zonebook_id', '$date_applied', 0
        )";

        if (mysqli_query($con, $insert_meter_sql)) {
            $new_meters_id = mysqli_insert_id($con);

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
                    "message" => "New account ($account_no) and charges recorded.",
                    "meters_id" => $new_meters_id,
                    "account_no" => $account_no // return the generated account number
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
