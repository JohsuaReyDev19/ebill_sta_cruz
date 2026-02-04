<?php
// Include your database connection file
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $zonebook = strtoupper(mysqli_real_escape_string($con, $_POST['zonebook']));
    $zonebook_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['zonebook_remarks']));

    // SQL query to insert new concessionaire
    $sql = "INSERT INTO `zonebook_settings`(`zonebook`, `zonebook_remarks`) 
    VALUES ('$zonebook', '$zonebook_remarks')";

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
