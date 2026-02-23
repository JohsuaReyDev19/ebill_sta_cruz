<?php
require '../../db/dbconn.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $billing_schedule_id = intval($_POST['billing_schedule_id']);
    $reading_date = $_POST['reading_date'];
    $date_from = $_POST['date_covered_from'];
    $date_to = $_POST['date_covered_to'];
    $zonebook_id = intval($_POST['zonebook_id']);

    // Basic validation
    if (
        empty($billing_schedule_id) ||
        empty($reading_date) ||
        empty($date_from) ||
        empty($date_to) ||
        empty($zonebook_id)
    ) {
        echo "missing_fields";
        exit();
    }

    // Check duplicate
    $check = mysqli_prepare($con, "
        SELECT reading_schedule_id 
        FROM reading_schedule_per_zone
        WHERE billing_schedule_id = ?
        AND zonebook_id = ?
        AND deleted = 0
    ");

    mysqli_stmt_bind_param($check, "ii", $billing_schedule_id, $zonebook_id);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        echo "duplicate";
        exit();
    }

    // Insert
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

    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "error";
    }

    exit();
}