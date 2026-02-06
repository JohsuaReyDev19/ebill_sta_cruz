<?php
require '../../db/dbconn.php';

$query = mysqli_query($con, "SELECT * FROM rates ORDER BY id DESC");

$data = [];

$count = 1;

while ($row = mysqli_fetch_assoc($query)) {

    $data[] = [
        $count++,
        htmlspecialchars($row['description']),
        number_format($row['rate'], 2),
        '
        <button class="btn btn-sm btn-primary edit-rate-btn"
            data-id="'.$row['id'].'"
            data-description="'.htmlspecialchars($row['description']).'"
            data-rate="'.$row['rate'].'">
            <i class="fa-solid fa-edit"></i>
        </button>

        <button class="btn btn-sm btn-danger delete-rate-btn"
            data-id="'.$row['id'].'"
            data-description="'.htmlspecialchars($row['description']).'">
            <i class="fa-solid fa-trash"></i>
        </button>
        '
    ];

}

echo json_encode([
    "data" => $data
]);
