<?php
require '../../db/dbconn.php';
require '../../config.php';

if (isset($_POST['concessionaire_id'], $_POST['status'])) {

    $encryptedId = $_POST['concessionaire_id'];
    $status = $_POST['status'];

    $allowedStatus = ['Active', 'Temporary Disconnected', 'Disconnected'];
    if (!in_array($status, $allowedStatus)) {
        echo 'error';
        exit;
    }

    $concessionaire_id = openssl_decrypt(
        $encryptedId,
        'aes-256-cbc',
        $encryptionKey,
        0,
        $iv
    );

    $stmt = $con->prepare(
        "UPDATE concessionaires SET status = ? WHERE concessionaires_id = ?"
    );
    $stmt->bind_param("si", $status, $concessionaire_id);

    echo $stmt->execute() ? 'success' : 'error';
}
mysqli_close($con);
