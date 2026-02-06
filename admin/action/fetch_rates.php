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
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
            Edit
        </button>

        <button class="btn btn-sm btn-danger delete-rate-btn"
            data-id="'.$row['id'].'"
            data-description="'.htmlspecialchars($row['description']).'">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
        </button>
        '
    ];

}

echo json_encode([
    "data" => $data
]);
