<?php
require '../../db/dbconn.php';
include '../function/formatFractionString.php';

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ================================
    // Sanitize Inputs
    // ================================
    $concessionaires_id = mysqli_real_escape_string($con, $_POST['concessionaires_id'] ?? '');
    $account_type       = mysqli_real_escape_string($con, $_POST['account_type'] ?? '');
    $classification     = mysqli_real_escape_string($con, $_POST['classification'] ?? '');
    $meter_no           = mysqli_real_escape_string($con, $_POST['meter_no'] ?? '');
    $meter_size_id      = mysqli_real_escape_string($con, $_POST['meter_size'] ?? '');
    $meter_brand_id     = mysqli_real_escape_string($con, $_POST['meter_brand'] ?? '');
    $zonebook_id        = mysqli_real_escape_string($con, $_POST['zonebook'] ?? '');
    $date_applied       = mysqli_real_escape_string($con, $_POST['date_applied'] ?? '');
    $house_no           = mysqli_real_escape_string($con, $_POST['house_no'] ?? '');
    $new_barangay       = mysqli_real_escape_string($con, $_POST['new_address'] ?? '');
    $old_barangay       = mysqli_real_escape_string($con, $_POST['old_address'] ?? '');
    $billing_date       = date('Y-m-d');

    // ================================
    // Determine Barangay
    // ================================
    $barangay = !empty($new_barangay) ? $new_barangay : $old_barangay;

    // ================================
    // Required Fields Validation
    // ================================
    if (
        empty($meter_no) ||
        empty($meter_size_id) ||
        empty($meter_brand_id) ||
        empty($zonebook_id) ||
        empty($account_type) ||
        empty($classification) ||
        empty($house_no) ||
        empty($barangay)
    ) {
        $response = ["status" => "error", "message" => "Required fields are missing."];
        echo json_encode($response);
        exit;
    }

    // ================================
    // Get Zone Code
    // ================================
    $zoneQuery = mysqli_query($con, "SELECT zonebook FROM zonebook_settings WHERE zonebook_id = '$zonebook_id'");
    $zoneRow   = mysqli_fetch_assoc($zoneQuery);

    if (!$zoneRow) {
        echo json_encode(["status" => "error", "message" => "Invalid zonebook."]);
        exit;
    }

    $zoneCode = str_pad($zoneRow['zonebook'], 3, '0', STR_PAD_LEFT);

    // ================================
    // Get Meter Size
    // ================================
    $meterQuery = mysqli_query($con, "SELECT meter_size FROM meter_size_settings WHERE meter_size_id = '$meter_size_id'");
    $meterRow   = mysqli_fetch_assoc($meterQuery);

    if (!$meterRow) {
        echo json_encode(["status" => "error", "message" => "Invalid meter size."]);
        exit;
    }

    $meterSizeRaw = $meterRow['meter_size'];

    // Convert meter size to code
    $meterCode = match($meterSizeRaw) {
        "1/2"     => "A",
        "1"       => "B",
        "1 1/2"   => "B",
        "2"       => "C",
        "2 1/2"   => "C",
        "3"       => "D",
        "3 1/2"   => "D",
        "4", "4 1/2" => "E",
        default   => $meterSizeRaw
    };

    // ================================
    // Get Classification Code
    // ================================
    $classificationQuery = mysqli_query($con, "SELECT classification FROM classification_settings WHERE classification_id = '$classification'");
    $classificationRow   = mysqli_fetch_assoc($classificationQuery);

    if (!$classificationRow) {
        echo json_encode(["status" => "error", "message" => "Invalid classification."]);
        exit;
    }

    $classification_name = $classificationRow['classification'];

    $code = match($classification_name) {
        "RESIDENTIAL", "GOVERNMENT"         => 1,
        "COMMERCIAL C"                      => 2,
        "COMMERCIAL B"                      => 3,
        "COMMERCIAL A"                      => 4,
        "COMMERCIAL / INDUSTRIAL"           => 5,
        default                              => 0
    };

    // ================================
    // Generate Account Number
    // ================================
    $likePattern = "$zoneCode-$code$meterCode-%";
    $seriesQuery = mysqli_query($con, "SELECT account_no FROM meters WHERE account_no LIKE '$likePattern' ORDER BY account_no DESC LIMIT 1");

    if (mysqli_num_rows($seriesQuery) > 0) {
        $last       = mysqli_fetch_assoc($seriesQuery);
        $lastSeries = intval(substr($last['account_no'], -3));
        $newSeries  = $lastSeries + 1;
    } else {
        $newSeries = 1;
    }

    $seriesCode = str_pad($newSeries, 3, '0', STR_PAD_LEFT);
    $account_no = "$zoneCode-$code$meterCode-$seriesCode";

    // ================================
    // Insert Into meters
    // ================================
    $insert_meter_sql = "INSERT INTO meters (
        concessionaires_id,
        account_no,
        account_type_id,
        classification_id,
        house_hold_number,
        barangay,
        meter_no,
        meter_size_id,
        meter_brand_id,
        zonebook_id,
        date_applied,
        service_status_id
    ) VALUES (
        '$concessionaires_id',
        '$account_no',
        '$account_type',
        '$classification',
        '$house_no',
        '$barangay',
        '$meter_no',
        '$meter_size_id',
        '$meter_brand_id',
        '$zonebook_id',
        '$date_applied',
        1
    )";

    if (!mysqli_query($con, $insert_meter_sql)) {
        echo json_encode(["status" => "error", "message" => "Failed to create account: " . mysqli_error($con)]);
        exit;
    }

    $new_meters_id = mysqli_insert_id($con);

    // ================================
    // Get Meter Details for Billing
    // ================================
    $meter_size_query = mysqli_query($con, "SELECT meter_size, unit_price FROM meter_size_settings WHERE meter_size_id = '$meter_size_id'");
    $meter_size_row   = mysqli_fetch_assoc($meter_size_query);

    $meter_brand_query = mysqli_query($con, "SELECT meter_brand FROM meter_brand_settings WHERE meter_brand_id = '$meter_brand_id'");
    $meter_brand_row   = mysqli_fetch_assoc($meter_brand_query);

    $meter_size_label = formatFractionString($meter_size_row['meter_size']);
    $unit_price       = floatval($meter_size_row['unit_price']);
    $meter_brand      = $meter_brand_row['meter_brand'];

    $units_included = "$meter_brand $meter_size_label";
    $amount_due     = $unit_price;
    $description    = "Opening of new account with meter $units_included";

    // ================================
    // Insert Into other_billing
    // ================================
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

    if (!mysqli_query($con, $insert_billing_sql)) {
        echo json_encode([
            "status" => "error",
            "message" => "Account created but billing failed: " . mysqli_error($con)
        ]);
        exit;
    }

    $response = [
        "status" => "success",
        "message" => "New account ($account_no) and charges recorded.",
        "meters_id" => $new_meters_id,
        "account_no" => $account_no
    ];

} else {
    $response = ["status" => "error", "message" => "Invalid request."];
}

header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($con);