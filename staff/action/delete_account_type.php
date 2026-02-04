<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if account_type_id is provided and is numeric
if (isset($_POST['account_type_id']) && is_numeric($_POST['account_type_id'])) {
    // Sanitize the input to prevent SQL injection
    $account_type_id = mysqli_real_escape_string($con, $_POST['account_type_id']);

    // SQL query to update the 'deleted' flag
    $sql = "UPDATE account_type_settings SET deleted = 1 WHERE account_type_id = '$account_type_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error';
    }
} else {
    // If account_type_id is not provided or is not numeric, return error
    echo 'error';
}

// Close the database connection
mysqli_close($con);
?>
