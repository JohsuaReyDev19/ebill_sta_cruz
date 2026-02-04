<?php
require '../../db/dbconn.php';

$response = array(); // Initialize response array

// Check if zonebook_id is provided and is numeric
if (isset($_POST['zonebook_id']) && is_numeric($_POST['zonebook_id'])) {
    // Sanitize inputs to prevent SQL injection
    $zonebook_id = mysqli_real_escape_string($con, $_POST['zonebook_id']);
    $zonebook = strtoupper(mysqli_real_escape_string($con, $_POST['zonebook']));
    $zonebook_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['zonebook_remarks']));

    // Update the zonebook_settings with the new values
    $sql = "UPDATE zonebook_settings SET 
            zonebook='$zonebook', 
            zonebook_remarks='$zonebook_remarks'
            WHERE zonebook_id='$zonebook_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // Success response
        $response = array("status" => "success", "message" => "Zone/Book updated successfully.");
    } else {
        // Error response
        $response = array("status" => "error", "message" => "Failed to update Zone/Book: " . mysqli_error($con));
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
