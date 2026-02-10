<?php
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $description = mysqli_real_escape_string($con, $_POST['description']);

    $query = "SELECT rate FROM rates WHERE description = '$description' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            "status" => "success",
            "rate" => $row['rate']
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "rate" => 0
        ]);
    }
}
