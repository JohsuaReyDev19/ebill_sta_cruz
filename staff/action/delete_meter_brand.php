<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if meter_brand_id is provided and is numeric
if (isset($_POST['meter_brand_id']) && is_numeric($_POST['meter_brand_id'])) {
    // Sanitize the input to prevent SQL injection
    $meter_brand_id = mysqli_real_escape_string($con, $_POST['meter_brand_id']);

    // SQL query to update the 'deleted' flag
    $sql = "UPDATE meter_brand_settings SET deleted = 1 WHERE meter_brand_id = '$meter_brand_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error';
    }
} else {
    // If meter_brand_id is not provided or is not numeric, return error
    echo 'error';
}

// Close the database connection
mysqli_close($con);
?>
