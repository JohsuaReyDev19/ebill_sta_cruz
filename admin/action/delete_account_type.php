<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if account_type_id is provided and is numeric
if (isset($_POST['account_type_id']) && is_numeric($_POST['account_type_id'])) {
    // Sanitize the input to prevent SQL injection
    $account_type_id = (int) $_POST['account_type_id'];

    $stmt = $con->prepare("DELETE FROM account_type_settings WHERE account_type_id = ?");

    $stmt->bind_param("i", $account_type_id);

    if($stmt->execute()){
        echo "success";
    }else{
        echo "error";
    }
}else{
    echo "error";
}

// Close the database connection
$con->close();
?>
