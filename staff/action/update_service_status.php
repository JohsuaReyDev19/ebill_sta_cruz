<?php
require '../../db/dbconn.php';

$response = array(); // Initialize response array

// Check if service_status_id is provided and is numeric
if (isset($_POST['service_status_id']) && is_numeric($_POST['service_status_id'])) {
    // Sanitize inputs to prevent SQL injection
    $service_status_id = mysqli_real_escape_string($con, $_POST['service_status_id']);
    $service_status = strtoupper(mysqli_real_escape_string($con, $_POST['service_status']));
    $service_status_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['service_status_remarks']));

    // Update the service_status_settings with the new values
    $sql = "UPDATE service_status_settings SET 
            service_status='$service_status', 
            service_status_remarks='$service_status_remarks'
            WHERE service_status_id='$service_status_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // Success response
        $response = array("status" => "success", "message" => "Service status updated successfully.");
    } else {
        // Error response
        $response = array("status" => "error", "message" => "Failed to update service status: " . mysqli_error($con));
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
