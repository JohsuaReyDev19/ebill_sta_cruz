<?php
// Include your database connection file
require '../../db/dbconn.php';

if (isset($_POST['meter_brand_id']) && is_numeric($_POST['meter_brand_id'])) {
    // Sanitize the input to prevent SQL injection
    $meter_brand_id = (int) $_POST['meter_brand_id'];

    $stmt = $con->prepare("DELETE FROM meter_brand_settings WHERE meter_brand_id = ?");
    $stmt->bind_param("i", $meter_brand_id);

    if($stmt->execute()){
        echo "success";
    }else{
        echo "error";
    }
}else{
    echo 'error';
}

$con->close();

?>


