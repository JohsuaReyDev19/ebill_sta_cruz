<?php
require '../../db/dbconn.php';

if (isset($_POST['reading_schedule_id'])) {

    $reading_schedule_id = intval($_POST['reading_schedule_id']);

    $stmt = mysqli_prepare($con, "
        DELETE FROM reading_schedule_per_zone
        WHERE reading_schedule_id = ?
    ");

    mysqli_stmt_bind_param($stmt, "i", $reading_schedule_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_stmt_close($stmt);
}
?>