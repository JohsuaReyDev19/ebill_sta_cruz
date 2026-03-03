<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');

$barangay_id     = $_POST['barangay_id'] ?? '';
$barangay        = trim($_POST['barangay'] ?? '');
$zones           = $_POST['zonebook_id'] ?? []; // ARRAY
$municipality_id = $_POST['citytownmunicipality_id'] ?? '1';

if(empty($barangay_id) || empty($barangay) || empty($zones)){
    echo json_encode([
        'status' => 'error',
        'message' => 'All fields are required.'
    ]);
    exit;
}

$con->begin_transaction();

try {

    // ✅ 1. Update barangay name + municipality only
    $stmt = $con->prepare("
        UPDATE barangay_settings 
        SET barangay = ?, citytownmunicipality_id = ?
        WHERE barangay_id = ?
    ");
    $stmt->bind_param("sii", $barangay, $municipality_id, $barangay_id);
    $stmt->execute();


    // ✅ 2. Delete old zone assignments
    $delete = $con->prepare("
        DELETE FROM zonebook_barangay 
        WHERE barangay_id = ?
    ");
    $delete->bind_param("i", $barangay_id);
    $delete->execute();


    // ✅ 3. Insert new zones
    $insert = $con->prepare("
        INSERT INTO zonebook_barangay (zonebook_id, barangay_id)
        VALUES (?, ?)
    ");

    foreach($zones as $zone_id){

        $zone_id = intval($zone_id);

        $insert->bind_param("ii", $zone_id, $barangay_id);
        $insert->execute();
    }

    $con->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Barangay and zones updated successfully.'
    ]);

} catch (Exception $e) {

    $con->rollback();

    echo json_encode([
        'status' => 'error',
        'message' => 'Update failed. Please try again.'
    ]);
}