<?php
require '../../db/dbconn.php';

$reading_schedule_id = $_POST['reading_schedule_id'] ?? '';
$billing_schedule_id = $_POST['billing_schedule_id'];
$reading_date = $_POST['reading_date'];
$date_from = $_POST['date_covered_from'];
$date_to = $_POST['date_covered_to'];
$zonebook_id = $_POST['zonebook_id'];

if ($reading_schedule_id != '') {

    // UPDATE
    $stmt = mysqli_prepare($con, "
        UPDATE reading_schedule_per_zone
        SET reading_date = ?, 
            date_covered_from = ?, 
            date_covered_to = ?, 
            zonebook_id = ?
        WHERE reading_schedule_id = ?
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "sssii",
        $reading_date,
        $date_from,
        $date_to,
        $zonebook_id,
        $reading_schedule_id
    );

} else {

    // INSERT
    $stmt = mysqli_prepare($con, "
        INSERT INTO reading_schedule_per_zone
        (billing_schedule_id, zonebook_id, reading_date, date_covered_from, date_covered_to)
        VALUES (?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "iisss",
        $billing_schedule_id,
        $zonebook_id,
        $reading_date,
        $date_from,
        $date_to
    );
}

mysqli_stmt_execute($stmt);

echo "success";
?>