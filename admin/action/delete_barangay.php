<?php
require '../../db/dbconn.php';

$barangay_id = $_POST['zonebook_id'] ?? '';

if(empty($barangay_id)){
    echo "error";
    exit;
}

$stmt = $con->prepare("
    UPDATE barangay_settings 
    SET deleted = 1 
    WHERE barangay_id = ?
");
$stmt->bind_param("i", $barangay_id);

if($stmt->execute()){
    echo "success";
}else{
    echo "error";
}
