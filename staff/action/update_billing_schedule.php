<?php
require '../../db/dbconn.php';

$response = array(); // Initialize response array

// Check if billing_schedule_id is provided and is numeric
if (isset($_POST['billing_schedule_id']) && is_numeric($_POST['billing_schedule_id'])) {
    // Sanitize inputs to prevent SQL injection
    $billing_schedule_id = mysqli_real_escape_string($con, $_POST['billing_schedule_id']);
    $reading_date = mysqli_real_escape_string($con, $_POST['reading_date']);
    $date_covered_from = mysqli_real_escape_string($con, $_POST['date_covered_from']);
    $date_covered_to = mysqli_real_escape_string($con, $_POST['date_covered_to']);
    $date_due = mysqli_real_escape_string($con, $_POST['date_due']);
    $date_disconnection = mysqli_real_escape_string($con, $_POST['date_disconnection']);

    // Update the classification_settings with the new values
    $sql = "UPDATE billing_schedule_settings SET 
            reading_date='$reading_date', 
            date_covered_from='$date_covered_from', 
            date_covered_to='$date_covered_to', 
            date_due='$date_due', 
            date_disconnection='$date_disconnection'
            WHERE billing_schedule_id='$billing_schedule_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // Success response
        $response = array("status" => "success", "message" => "Billing Schedule updated successfully.");
    } else {
        // Error response
        $response = array("status" => "error", "message" => "Failed to update Billing Schedule: " . mysqli_error($con));
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
