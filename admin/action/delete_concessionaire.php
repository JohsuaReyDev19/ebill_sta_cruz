<?php
require '../../db/dbconn.php';
require '../../config.php';

// Ensure the concessionaire_id is sent via POST
if (isset($_POST['concessionaire_id'])) {
    // Sanitize and validate the concessionaire_id
    $concessionaire_id = $_POST['concessionaire_id'];

    $decryptedData = openssl_decrypt($concessionaire_id, 'aes-256-cbc', $encryptionKey, 0, $iv);

    // Query to mark the concessionaire as deleted
    $query = "UPDATE concessionaires SET deleted = 1 WHERE concessionaires_id = '$decryptedData'";
    
    // Execute the query
    if (mysqli_query($con, $query)) {
        echo 'success';  // If deletion is successful
    } else {
        echo 'error';  // If there is an issue with the query
    }
} else {
    echo 'error';  // If no ID was provided in the POST request
}

mysqli_close($con);
?>
