<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $zonebook = strtoupper(trim(mysqli_real_escape_string($con, $_POST['zonebook'] ?? '')));
    $zonebook_remarks = strtoupper(trim(mysqli_real_escape_string($con, $_POST['zonebook_remarks'] ?? '')));

    if ($zonebook === '' || $zonebook_remarks === '') {
        echo json_encode(['status' => 'empty']);
        exit;
    }

    $checkSql = "SELECT 1 FROM zonebook_settings WHERE zonebook = '$zonebook' LIMIT 1";
    $checkResult = mysqli_query($con, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['status' => 'exists']);
        exit;
    }

    $sql = "INSERT INTO zonebook_settings (zonebook, zonebook_remarks)
            VALUES ('$zonebook', '$zonebook_remarks')";

    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}

mysqli_close($con);
