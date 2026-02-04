<?php
require '../../db/dbconn.php';
include '../function/formatFractionString.php';

$response = [];

if (isset($_POST['meters_id']) && is_numeric($_POST['meters_id'])) {
    $meters_id = mysqli_real_escape_string($con, $_POST['meters_id']);
    $meter_no = mysqli_real_escape_string($con, $_POST['meter_no']);
    $meter_size_id = mysqli_real_escape_string($con, $_POST['meter_size']);
    $meter_brand_id = mysqli_real_escape_string($con, $_POST['meter_brand']);
    $remarks = isset($_POST['remarks']) ? mysqli_real_escape_string($con, $_POST['remarks']) : 'Change meter';
    $billing_date = date('Y-m-d');

    if (empty($meter_no) || empty($meter_size_id) || empty($meter_brand_id)) {
        $response = ["status" => "error", "message" => "Required fields are missing."];
    } else {
        $check_sql = "SELECT meter_no, meter_size_id, meter_brand_id FROM meters WHERE meters_id = '$meters_id' LIMIT 1";
        $check_result = mysqli_query($con, $check_sql);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $existing = mysqli_fetch_assoc($check_result);

            if (
                $existing['meter_no'] === $meter_no &&
                $existing['meter_size_id'] === $meter_size_id &&
                $existing['meter_brand_id'] === $meter_brand_id
            ) {
                $response = ["status" => "nochange", "message" => "No changes were made to the meter information."];
            } else {
                $prev_meter_label = '';
                $new_meter_label = '';
                $new_meter_brand = '';
                $unit_price = 0;
                $amount_due = 0;
                $units_included = [];

                // Get previous meter size label
                $prev_id = $existing['meter_size_id'];
                $prev_query = mysqli_query($con, "SELECT meter_size FROM meter_size_settings WHERE meter_size_id = '$prev_id'");
                if ($prev_query && mysqli_num_rows($prev_query) > 0) {
                    $prev_meter_label = formatFractionString(mysqli_fetch_assoc($prev_query)['meter_size']);
                }

                // Get new meter size info
                $new_size_query = mysqli_query($con, "SELECT meter_size, unit_price FROM meter_size_settings WHERE meter_size_id = '$meter_size_id'");
                if ($new_size_query && mysqli_num_rows($new_size_query) > 0) {
                    $row = mysqli_fetch_assoc($new_size_query);
                    $new_meter_label = formatFractionString($row['meter_size']);
                    $unit_price = floatval($row['unit_price']);
                    $amount_due += $unit_price;
                }

                // Get new meter brand
                $brand_query = mysqli_query($con, "SELECT meter_brand FROM meter_brand_settings WHERE meter_brand_id = '$meter_brand_id'");
                if ($brand_query && mysqli_num_rows($brand_query) > 0) {
                    $new_meter_brand = mysqli_fetch_assoc($brand_query)['meter_brand'];
                }

                // Use only brand and size
                $units_included[] = "$new_meter_brand $new_meter_label";

                // Update meter
                $update_sql = "UPDATE meters SET 
                    meter_no = '$meter_no',
                    meter_size_id = '$meter_size_id',
                    meter_brand_id = '$meter_brand_id'
                    WHERE meters_id = '$meters_id'";

                if (mysqli_query($con, $update_sql)) {
                    $description = "Change of meter from $prev_meter_label to $new_meter_label";
                    $units_text = implode(' ', $units_included);

                    $insert_sql = "INSERT INTO other_billing (
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
                        '$meters_id',
                        '$units_text',
                        '$unit_price',
                        1,
                        '$amount_due',
                        '$remarks',
                        '$description',
                        '$billing_date',
                        0
                    )";

                    if (mysqli_query($con, $insert_sql)) {
                        $response = ["status" => "success", "message" => "Meter updated and charges successfully recorded."];
                    } else {
                        $response = ["status" => "error", "message" => "Meter updated, but failed to log charges: " . mysqli_error($con)];
                    }
                } else {
                    $response = ["status" => "error", "message" => "Failed to update meter info: " . mysqli_error($con)];
                }
            }
        } else {
            $response = ["status" => "error", "message" => "Meter record not found."];
        }
    }
} else {
    $response = ["status" => "error", "message" => "Invalid or missing meter ID."];
}

header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($con);
