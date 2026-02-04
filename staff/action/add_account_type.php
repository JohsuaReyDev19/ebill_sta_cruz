<?php
// Include your database connection file
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $account_type = strtoupper(mysqli_real_escape_string($con, $_POST['account_type']));
    $account_type_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['account_type_remarks']));

    // SQL query to insert new concessionaire
    $sql = "INSERT INTO `account_type_settings`(`account_type`, `account_type_remarks`) 
    VALUES ('$account_type', '$account_type_remarks')";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error: ' . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);
?>
