<?php
require '../../db/dbconn.php';

$barangay_id = $_POST['barangay_id'];
$zones = $_POST['zonebook_id'];

foreach($zones as $zone_id){
    
    // Prevent duplicate
    $check = mysqli_query($con,"
        SELECT * FROM zonebook_barangay
        WHERE barangay_id='$barangay_id'
        AND zonebook_id='$zone_id'
        AND deleted=0
    ");

    if(mysqli_num_rows($check) == 0){
        mysqli_query($con,"
            INSERT INTO zonebook_barangay (zonebook_id, barangay_id)
            VALUES ('$zone_id', '$barangay_id')
        ");
    }
}

echo "success";