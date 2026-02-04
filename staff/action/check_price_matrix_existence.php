<?php
// Include your database connection file
require '../../db/dbconn.php';

$classification_id = $_POST['classification_id'];
$meter_size_id = $_POST['meter_size_id'];
$exclude_id = isset($_POST['exclude_id']) ? $_POST['exclude_id'] : null;

$sql = "SELECT * FROM price_matrix 
        WHERE classification_id = '$classification_id' 
        AND meter_size_id = '$meter_size_id'";

if ($exclude_id) {
    $sql .= " AND price_matrix_id != '$exclude_id'";
}

$result = $con->query($sql);
echo ($result->num_rows > 0) ? 'exists' : 'not_exists';
?>
