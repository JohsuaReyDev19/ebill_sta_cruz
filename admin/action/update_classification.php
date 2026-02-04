<?php
require '../../db/dbconn.php';

$response = array(); // Initialize response array

// Check if classification_id is provided and is numeric
if (isset($_POST['classification_id']) && is_numeric($_POST['classification_id'])) {
    // Sanitize inputs to prevent SQL injection
    $classification_id = mysqli_real_escape_string($con, $_POST['classification_id']);
    $classification = strtoupper(mysqli_real_escape_string($con, $_POST['classification']));
    $classification_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['classification_remarks']));

    // Update the classification_settings with the new values
    $sql = "UPDATE classification_settings SET 
            classification='$classification', 
            classification_remarks='$classification_remarks'
            WHERE classification_id='$classification_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // Success response
        $response = array("status" => "success", "message" => "Classification updated successfully.");
    } else {
        // Error response
        $response = array("status" => "error", "message" => "Failed to update classification: " . mysqli_error($con));
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
