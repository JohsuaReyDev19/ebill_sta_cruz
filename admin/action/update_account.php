<?php
require '../../db/dbconn.php';

$response = array(); // Initialize response array

// Check if meters_id is provided and is numeric
if (isset($_POST['meters_id']) && is_numeric($_POST['meters_id'])) {
    // Sanitize inputs to prevent SQL injection
    $meters_id = mysqli_real_escape_string($con, $_POST['meters_id']);
    $account_no = isset($_POST['account_no']) ? mysqli_real_escape_string($con, $_POST['account_no']) : '';
    $house_no = isset($_POST['house_no']) ? mysqli_real_escape_string($con, $_POST['house_no']) : '';
    $account_type = isset($_POST['account_type']) ? mysqli_real_escape_string($con, $_POST['account_type']) : '';
    $barangay = isset($_POST['barangay']) ? mysqli_real_escape_string($con, $_POST['barangay']) : '';
    $classification = isset($_POST['classification']) ? mysqli_real_escape_string($con, $_POST['classification']) : '';
    $zonebook = isset($_POST['zonebook']) ? mysqli_real_escape_string($con, $_POST['zonebook']) : '';
    $date_applied = isset($_POST['date_applied']) ? mysqli_real_escape_string($con, $_POST['date_applied']) : date('Y-m-d');

    // Update the meters with the new values
    $sql = "UPDATE meters SET 
            account_no='$account_no',
            account_type_id='$account_type',
            classification_id='$classification',
            house_hold_number='$house_no',
            barangay='$barangay',
            zonebook_id='$zonebook',
            date_applied='$date_applied'
            WHERE meters_id='$meters_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // Success response
        $response = array("status" => "success", "message" => "Account updated successfully.");
    } else {
        // Error response
        $response = array("status" => "error", "message" => "Failed to update account: " . mysqli_error($con));
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
