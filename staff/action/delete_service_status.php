<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if service_status_id is provided and is numeric
if (isset($_POST['service_status_id']) && is_numeric($_POST['service_status_id'])) {
    // Sanitize the input to prevent SQL injection
    $service_status_id = mysqli_real_escape_string($con, $_POST['service_status_id']);

    // SQL query to update the 'deleted' flag
    $sql = "UPDATE service_status_settings SET deleted = 1 WHERE service_status_id = '$service_status_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error';
    }
} else {
    // If service_status_id is not provided or is not numeric, return error
    echo 'error';
}

// Close the database connection
mysqli_close($con);
?>
