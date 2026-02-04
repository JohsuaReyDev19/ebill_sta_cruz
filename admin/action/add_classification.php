<?php
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize inputs
    $classification = strtoupper(mysqli_real_escape_string($con, $_POST['classification']));
    $classification_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['classification_remarks']));

    // Empty validation (extra safety)
    if (empty($classification) || empty($classification_remarks)) {
        echo 'empty';
        exit;
    }

    //CHECK IF CLASSIFICATION ALREADY EXISTS
    $checkSql = "SELECT 1 FROM classification_settings 
                 WHERE classification = '$classification' 
                 LIMIT 1";
    $checkResult = mysqli_query($con, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        echo 'exists';
        exit;
    }

    $sql = "INSERT INTO classification_settings (classification, classification_remarks)
            VALUES ('$classification', '$classification_remarks')";

    if (mysqli_query($con, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
}

mysqli_close($con);
?>
