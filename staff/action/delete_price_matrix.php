<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if price_matrix_id is provided and is numeric
if (isset($_POST['price_matrix_id']) && is_numeric($_POST['price_matrix_id'])) {
    // Sanitize the input to prevent SQL injection
    $price_matrix_id = mysqli_real_escape_string($con, $_POST['price_matrix_id']);

    // SQL query to update the 'deleted' flag
    $sql = "UPDATE price_matrix SET deleted = 1 WHERE price_matrix_id = '$price_matrix_id'";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error';
    }
} else {
    // If price_matrix_id is not provided or is not numeric, return error
    echo 'error';
}

// Close the database connection
mysqli_close($con);
?>
