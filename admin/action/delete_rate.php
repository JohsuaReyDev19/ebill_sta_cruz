<?php
require '../../db/dbconn.php';

$id = $_POST['id'];

$delete = mysqli_query($con,
    "DELETE FROM rates WHERE id='$id'"
);

if ($delete) {
    echo "success";
} else {
    echo "error";
}
