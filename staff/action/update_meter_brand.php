<?php
require '../../db/dbconn.php';

$response = array(); // Initialize response array

// Check if meter_brand_id is provided and is numeric
if (isset($_POST['meter_brand_id']) && is_numeric($_POST['meter_brand_id'])) {
    // Sanitize inputs to prevent SQL injection
    $meter_brand_id = mysqli_real_escape_string($con, $_POST['meter_brand_id']);
    $meter_brand = strtoupper(mysqli_real_escape_string($con, $_POST['meter_brand']));
    $meter_brand_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['meter_brand_remarks']));

    // Update the meter_brand_settings with the new values
    $sql = "UPDATE meter_brand_settings SET 
            meter_brand='$meter_brand', 
            meter_brand_remarks='$meter_brand_remarks'
            WHERE meter_brand_id='$meter_brand_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // Success response
        $response = array("status" => "success", "message" => "Meter Brand updated successfully.");
    } else {
        // Error response
        $response = array("status" => "error", "message" => "Failed to update Meter Brand: " . mysqli_error($con));
    }
} else {
    // If required parameters are missing
    $response = array("status" => "error", "message" => "Invalid or missing parameters");
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
mysqli_close($con);
?>
