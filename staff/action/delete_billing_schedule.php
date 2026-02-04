<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if billing_schedule_id is provided and is numeric
if (isset($_POST['billing_schedule_id']) && is_numeric($_POST['billing_schedule_id'])) {
    // Sanitize the input to prevent SQL injection
    $billing_schedule_id = mysqli_real_escape_string($con, $_POST['billing_schedule_id']);

    // SQL query to update the 'deleted' flag
    $sql = "UPDATE billing_schedule_settings SET deleted = 1 WHERE billing_schedule_id = '$billing_schedule_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error';
    }
} else {
    // If billing_schedule_id is not provided or is not numeric, return error
    echo 'error';
}

// Close the database connection
mysqli_close($con);
?>
