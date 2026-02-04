<?php
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize inputs
    $account_type = strtoupper(mysqli_real_escape_string($con, $_POST['account_type']));
    $account_type_remarks = strtoupper(mysqli_real_escape_string($con, $_POST['account_type_remarks']));

    // Empty validation (extra safety)
    if (empty($account_type) || empty($account_type_remarks)) {
        echo 'empty';
        exit;
    }

    //CHECK IF ACCOUNT TYPE ALREADY EXISTS
    $checkSql = "SELECT 1 FROM account_type_settings 
                 WHERE account_type = '$account_type' 
                 LIMIT 1";
    $checkResult = mysqli_query($con, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        echo 'exists';
        exit;
    }

    // INSERT NEW ACCOUNT TYPE
    $sql = "INSERT INTO account_type_settings (account_type, account_type_remarks)
            VALUES ('$account_type', '$account_type_remarks')";

    if (mysqli_query($con, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
}

mysqli_close($con);
?>
