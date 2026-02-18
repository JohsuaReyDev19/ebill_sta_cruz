<?php
// Include your database connection file
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $meter_size = strtoupper(mysqli_real_escape_string($con, $_POST['meter_size']));
    $unit_price = floatval($_POST['unit_price']);
    $meter_size_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['meter_size_remarks']));
    $meter_brand = strtoupper(mysqli_real_escape_string($con, $_POST['meter_brand']));

    // SQL query to insert new concessionaire
    $sql = "INSERT INTO `meter_size_settings`(`meter_size`,`meter_brand`, `unit_price`, `meter_size_remarks`) 
    VALUES ('$meter_size', '$meter_brand', '$unit_price', '$meter_size_remarks')";

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
