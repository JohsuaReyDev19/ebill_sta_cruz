<?php
// Include your database connection file
require '../../db/dbconn.php';

if (isset($_POST['citytown_id'])) {
    $citytown_id = $_POST['citytown_id'];
    $sqlFetchBarangays = "SELECT * FROM barangay_settings WHERE citytownmunicipality_id = ? AND deleted = 0";
    $stmt = $con->prepare($sqlFetchBarangays);
    $stmt->bind_param('i', $citytown_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $barangays = array();
    while ($row = $result->fetch_assoc()) {
        $barangays[] = array(
            'barangay_id' => $row['barangay_id'],
            'barangay_name' => $row['barangay']
        );
    }
    
    echo json_encode($barangays);
}
?>
