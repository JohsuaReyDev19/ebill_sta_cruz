<?php
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $description = mysqli_real_escape_string($con, $_POST['description']);
    $rate = mysqli_real_escape_string($con, $_POST['rate']);

    if (empty($description) || empty($rate)) {
        echo "empty";
        exit;
    }

    // Check duplicate
    $check = mysqli_query($con, "SELECT id FROM rates WHERE description='$description'");
    if (mysqli_num_rows($check) > 0) {
        echo "exists";
        exit;
    }

    $insert = mysqli_query($con, 
        "INSERT INTO rates (description, rate) 
         VALUES ('$description', '$rate')"
    );

    if ($insert) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
