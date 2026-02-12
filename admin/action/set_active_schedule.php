<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if billing_schedule_id is provided and is numeric
if (isset($_POST['schedule_id']) && is_numeric($_POST['schedule_id'])) {
    // Sanitize the input to prevent SQL injection
    $billing_schedule_id = mysqli_real_escape_string($con, $_POST['schedule_id']);

    // SQL query to deactivate all schedules and activate the selected one
    $sql = "
        UPDATE billing_schedule_settings
        SET set_active = CASE
            WHEN billing_schedule_id = '$billing_schedule_id' THEN 1
            ELSE 0
        END
        WHERE deleted = 0";

        $updateBill = "UPDATE meters SET deleted = 0, bill = 0";
    // Execute the query
    if (mysqli_query($con, $sql) AND mysqli_query($con, $updateBill)) {
        // If the query is successful, return success
        echo 'success';
    } else {
        // If the query fails, return error
        echo 'error';
    }
} else {
    // If billing_schedule_id is not provided or is not numeric, return error
    echo 'error';
}

// Close the database connection
mysqli_close($con);
?>
