<?php
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize inputs
    $meter_brand = strtoupper(mysqli_real_escape_string($con, $_POST['meter_brand']));
    $meter_brand_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['meter_brand_remarks']));

    //Empty field validation
    if (empty($meter_brand) || empty($meter_brand_remarks)) {
        echo 'empty';
        exit;
    }

    $checkSql = "SELECT 1 FROM meter_brand_settings
                 WHERE meter_brand = '$meter_brand'
                 LIMIT 1";
    $checkResult = mysqli_query($con, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        echo 'exists'; // 🔹 standardized response
        exit;
    }

    $sql = "INSERT INTO meter_brand_settings (meter_brand, meter_brand_remarks)
            VALUES ('$meter_brand', '$meter_brand_remarks')";

    if (mysqli_query($con, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
}

mysqli_close($con);
?>
