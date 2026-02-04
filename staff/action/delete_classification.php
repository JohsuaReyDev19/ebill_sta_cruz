<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if classification_id is provided and is numeric
if (isset($_POST['classification_id']) && is_numeric($_POST['classification_id'])) {
    // Sanitize the input to prevent SQL injection
    $classification_id = mysqli_real_escape_string($con, $_POST['classification_id']);

    // SQL query to update the 'deleted' flag
    $sql = "UPDATE classification_settings SET deleted = 1 WHERE classification_id = '$classification_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error';
    }
} else {
    // If classification_id is not provided or is not numeric, return error
    echo 'error';
}

// Close the database connection
mysqli_close($con);
?>
