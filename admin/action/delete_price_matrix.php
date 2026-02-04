<?php
// Include your database connection file
require '../../db/dbconn.php';

// Check if price_matrix_id is provided and is numeric
if (isset($_POST['price_matrix_id']) && is_numeric($_POST['price_matrix_id'])) {
    // Sanitize the input to prevent SQL injection
    $price_matrix_id = mysqli_real_escape_string($con, $_POST['price_matrix_id']);

    $stmt = $con->prepare("DELETE FROM price_matrix WHERE price_matrix_id = ?");
    $stmt->bind_param("i", $price_matrix_id);

    if($stmt->execute()){
        echo "success";
    }else{
        echo "error";
    }
} else {
    // If price_matrix_id is not provided or is not numeric, return error
    echo 'error';
}

// Close the database connection
$con->close();
?>
