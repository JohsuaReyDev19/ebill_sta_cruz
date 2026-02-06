<?php
require '../../db/dbconn.php';
header('Content-Type: application/json');

$id = $_POST['id'];
$description = mysqli_real_escape_string($con, $_POST['description']);
$rate = mysqli_real_escape_string($con, $_POST['rate']);

if (empty($description) || empty($rate)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'All fields are required.'
    ]);
    exit;
}

$update = mysqli_query($con,
    "UPDATE rates
     SET description='$description',
         rate='$rate'
     WHERE id='$id'"
);

if ($update) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Rate updated successfully!'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Update failed.'
    ]);
}
