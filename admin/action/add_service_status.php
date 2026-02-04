<?php
// Include your database connection file
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $service_status = strtoupper(mysqli_real_escape_string($con, $_POST['service_status']));
    $service_status_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['service_status_remarks']));

    // SQL query to insert new concessionaire
    $sql = "INSERT INTO `service_status_settings`(`service_status`, `service_status_remarks`) 
    VALUES ('$service_status', '$service_status_remarks')";

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
