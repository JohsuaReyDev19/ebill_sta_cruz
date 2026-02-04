<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if zonebook_id is provided and is numeric
if (isset($_POST['zonebook_id']) && is_numeric($_POST['zonebook_id'])) {
    // Sanitize the input to prevent SQL injection
    $zonebook_id = mysqli_real_escape_string($con, $_POST['zonebook_id']);

    // SQL query to update the 'deleted' flag
    $sql = "UPDATE zonebook_settings SET deleted = 1 WHERE zonebook_id = '$zonebook_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error';
    }
} else {
    // If zonebook_id is not provided or is not numeric, return error
    echo 'error';
}

// Close the database connection
mysqli_close($con);
?>
