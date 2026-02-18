<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');

$barangay_id = $_POST['barangay_id'] ?? '';
$barangay = trim($_POST['barangay'] ?? '');
$zonebook_id = $_POST['zonebook_id'] ?? '';
$municipality_id = $_POST['citytownmunicipality_id'] ?? '';

if(empty($barangay_id) || empty($barangay) || empty($zonebook_id) || empty($municipality_id)){
    echo json_encode([
        'status' => 'error',
        'message' => 'All fields are required.'
    ]);
    exit;
}

// Check duplicate (excluding self)
$check = $con->prepare("
    SELECT 1 FROM barangay_settings
    WHERE barangay = ?
    AND zonebook_id = ?
    AND citytownmunicipality_id = ?
    AND barangay_id != ?
    AND deleted = 0
");
$check->bind_param("siii", $barangay, $zonebook_id, $municipality_id, $barangay_id);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    echo json_encode([
        'status' => 'error',
        'message' => 'This barangay already exists in the selected zone and municipality.'
    ]);
    exit;
}

// Update
$stmt = $con->prepare("
    UPDATE barangay_settings 
    SET barangay = ?, zonebook_id = ?, citytownmunicipality_id = ?
    WHERE barangay_id = ?
");
$stmt->bind_param("siii", $barangay, $zonebook_id, $municipality_id, $barangay_id);

if($stmt->execute()){
    echo json_encode([
        'status' => 'success',
        'message' => 'Barangay updated successfully.'
    ]);
}else{
    echo json_encode([
        'status' => 'error',
        'message' => 'Update failed. Please try again.'
    ]);
}
