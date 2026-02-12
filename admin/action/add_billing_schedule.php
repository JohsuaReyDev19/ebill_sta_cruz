<?php
// Include your database connection file
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $reading_date = mysqli_real_escape_string($con, $_POST['reading_date']);
    $date_covered_from = mysqli_real_escape_string($con, $_POST['date_covered_from']);
    $date_covered_to = mysqli_real_escape_string($con, $_POST['date_covered_to']);
    $date_due = mysqli_real_escape_string($con, $_POST['date_due']);
    $date_disconnection = mysqli_real_escape_string($con, $_POST['date_disconnection']);

    $updateSql = "UPDATE meters SET deleted = 0";


    // SQL query to insert new concessionaire
    $sql = "INSERT INTO `billing_schedule_settings`(`reading_date`, `date_covered_from`, `date_covered_to`, `date_due`, `date_disconnection`) 
    VALUES ('$reading_date', '$date_covered_from', '$date_covered_to', '$date_due', '$date_disconnection')";

    // Execute the query
    if (mysqli_query($con, $sql) AND mysqli_query($con, $updateSql)) {
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
