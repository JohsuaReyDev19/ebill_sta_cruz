<?php
require '../../db/dbconn.php';

$response = array(); // Initialize response array

// Check if required POST parameters are present
if (
    isset($_POST['price_matrix_id']) && is_numeric($_POST['price_matrix_id']) &&
    isset($_POST['classification_id']) && is_numeric($_POST['classification_id']) &&
    isset($_POST['meter_size_id']) && is_numeric($_POST['meter_size_id']) &&
    isset($_POST['price_per_cubic_meter'])
) {
    // Sanitize inputs
    $price_matrix_id = mysqli_real_escape_string($con, $_POST['price_matrix_id']);
    $classification_id = mysqli_real_escape_string($con, $_POST['classification_id']);
    $meter_size_id = mysqli_real_escape_string($con, $_POST['meter_size_id']);
    $price_per_cubic_meter = floatval($_POST['price_per_cubic_meter']);

    // Validate minimum price
    if ($price_per_cubic_meter <= 0) {
        $response = array("status" => "error", "message" => "Minimum price must be greater than 0.");
    } else {
        // Check if the combination already exists (excluding this current row)
        $checkSql = "SELECT * FROM price_matrix 
                     WHERE classification_id = '$classification_id' 
                       AND meter_size_id = '$meter_size_id' 
                       AND price_matrix_id != '$price_matrix_id' 
                       AND deleted = 0";
        $checkResult = mysqli_query($con, $checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            $response = array("status" => "error", "message" => "This price matrix already exists.");
        } else {
            // Proceed with update
            $updateSql = "UPDATE price_matrix SET 
                            classification_id = '$classification_id', 
                            meter_size_id = '$meter_size_id', 
                            price_per_cubic_meter = '$price_per_cubic_meter' 
                          WHERE price_matrix_id = '$price_matrix_id'";

            if (mysqli_query($con, $updateSql)) {
                $response = array("status" => "success", "message" => "Price Matrix updated successfully.");
            } else {
                $response = array("status" => "error", "message" => "Failed to update Price Matrix: " . mysqli_error($con));
            }
        }
    }
} else {
    $response = array("status" => "error", "message" => "Invalid or missing parameters.");
}

// Output response in JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the DB connection
mysqli_close($con);
?>
