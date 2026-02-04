<?php
require '../../db/dbconn.php';

$response = array(); // Initialize response array

// Check if meter_size_id is provided and is numeric
if (isset($_POST['meter_size_id']) && is_numeric($_POST['meter_size_id'])) {
    // Sanitize inputs to prevent SQL injection
    $meter_size_id = mysqli_real_escape_string($con, $_POST['meter_size_id']);
    $meter_size = strtoupper(mysqli_real_escape_string($con, $_POST['meter_size']));
    $unit_price = floatval($_POST['unit_price']);
    $meter_size_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['meter_size_remarks']));

    // Update the meter_size_settings with the new values
    $sql = "UPDATE meter_size_settings SET 
            meter_size='$meter_size', 
            unit_price='$unit_price', 
            meter_size_remarks='$meter_size_remarks'
            WHERE meter_size_id='$meter_size_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // Success response
        $response = array("status" => "success", "message" => "Meter Size updated successfully.");
    } else {
        // Error response
        $response = array("status" => "error", "message" => "Failed to update Meter Size: " . mysqli_error($con));
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
