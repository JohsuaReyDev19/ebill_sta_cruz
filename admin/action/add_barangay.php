<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');

$barangay = trim($_POST['barangay'] ?? '');
$zonebook_id = $_POST['zonebook_id'] ?? '';
$municipality_id = $_POST['citytownmunicipality_id'] ?? '';

if(empty($barangay) || empty($zonebook_id) || empty($municipality_id)){
    echo json_encode(['status' => 'empty']);
    exit;
}

// Duplicate check (barangay + zone + municipality)
$check = $con->prepare("
    SELECT 1 FROM barangay_settings 
    WHERE barangay = ? 
    AND zonebook_id = ?
    AND citytownmunicipality_id = ?
    AND deleted = 0
");
$check->bind_param("sii", $barangay, $zonebook_id, $municipality_id);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    echo json_encode(['status' => 'exists']);
    exit;
}

// Insert
$stmt = $con->prepare("
    INSERT INTO barangay_settings 
    (barangay, zonebook_id, citytownmunicipality_id) 
    VALUES (?, ?, ?)
");
$stmt->bind_param("sii", $barangay, $zonebook_id, $municipality_id);

if($stmt->execute()){
    echo json_encode(['status' => 'success']);
}else{
    echo json_encode(['status' => 'error']);
}
