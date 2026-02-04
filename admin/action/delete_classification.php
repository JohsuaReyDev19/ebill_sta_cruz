<?php
// Include your database connection file
require '../../db/dbconn.php';

if (isset($_POST['classification_id']) && is_numeric($_POST['classification_id'])) {
    $classification_id = mysqli_real_escape_string($con, $_POST['classification_id']);

    $stmt  = $con->prepare("DELETE FROM classification_settings WHERE classification_id = ?");
    $stmt->bind_param("i", $classification_id);

    
    //PREPARE DELETE QUERY
    if($stmt->execute()){
        echo "success";
    }else{
        echo "error";
    }
} else {
    echo 'error';
}

// Close the database connection
$con->close();

?>
