<?php
require '../../db/dbconn.php';

 $query = "SELECT status  FROM users";

$result = mysqli_query($con, $query);



while ($row = mysqli_fetch_assoc($result)) {
    if($row["status"] == 0){
        echo "pending";
    }elseif($row["status"] == 1){
        echo "active";

    }elseif($row["status"] == 2){
        echo "declined";
    }
}

// $sql = "SELECT COUNT(status) AS total FROM users";
// $query = mysqli_query($con, $sql);

// $row = mysqli_fetch_assoc($query);

// echo $row['total'];
?>
