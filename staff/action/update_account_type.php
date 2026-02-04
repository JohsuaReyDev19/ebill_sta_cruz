<?php
require '../../db/dbconn.php';

$response = array(); // Initialize response array

// Check if account_type_id is provided and is numeric
if (isset($_POST['account_type_id']) && is_numeric($_POST['account_type_id'])) {
    // Sanitize inputs to prevent SQL injection
    $account_type_id = mysqli_real_escape_string($con, $_POST['account_type_id']);
    $account_type = strtoupper(mysqli_real_escape_string($con, $_POST['account_type']));
    $account_type_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['account_type_remarks']));

    // Update the account_type_settings with the new values
    $sql = "UPDATE account_type_settings SET 
            account_type='$account_type', 
            account_type_remarks='$account_type_remarks'
            WHERE account_type_id='$account_type_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // Success response
        $response = array("status" => "success", "message" => "Account Type updated successfully.");
    } else {
        // Error response
        $response = array("status" => "error", "message" => "Failed to update Account Type: " . mysqli_error($con));
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
