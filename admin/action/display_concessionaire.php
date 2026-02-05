<?php
require '../../db/dbconn.php';
require '../../config.php';

// Read POST parameters sent by DataTables
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];

// Build base query
$query = "
    SELECT 
        ct.*, 
        CASE 
            WHEN ct.is_institution = 1 THEN ct.institution_name
            ELSE CONCAT(ct.last_name, ', ', ct.first_name, ' ', ct.middle_name)
        END AS full_name,
        CONCAT(ctms_home.citytownmunicipality, ', ', bs_home.barangay) AS home_address, 
        CONCAT(ctms_billing.citytownmunicipality, ', ', bs_billing.barangay) AS billing_address,
        GROUP_CONCAT(m.account_no SEPARATOR ', ') AS accounts_info
    FROM `concessionaires` ct
    INNER JOIN `citytownmunicipality_settings` ctms_home ON ctms_home.citytownmunicipality_id = ct.home_citytownmunicipality_id
    INNER JOIN `barangay_settings` bs_home ON bs_home.barangay_id = ct.home_barangay_id
    INNER JOIN `citytownmunicipality_settings` ctms_billing ON ctms_billing.citytownmunicipality_id = ct.billing_citytownmunicipality_id
    INNER JOIN `barangay_settings` bs_billing ON bs_billing.barangay_id = ct.billing_barangay_id
    LEFT JOIN `meters` m ON m.concessionaires_id = ct.concessionaires_id AND m.deleted = 0
    WHERE ct.deleted = 0
";

// Add search functionality
if (!empty($searchValue)) {
    $query .= " AND (CONCAT(ct.first_name, ' ', ct.middle_name, ' ', ct.last_name) LIKE '%$searchValue%' OR 
                     bs_home.barangay LIKE '%$searchValue%' OR 
                     bs_billing.barangay LIKE '%$searchValue%' OR 
                     m.account_no LIKE '%$searchValue%')";
}

// Group by concessionaire and order
$query .= " GROUP BY ct.concessionaires_id ORDER BY ct.date_added ASC";

// Add limit and offset for pagination
$query .= " LIMIT $start, $length";

$result = mysqli_query($con, $query);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $profileImagePath = "../upload/profile/" . $row['profile'];
    $concessionaires_id = $row['concessionaires_id'];
    $encryptedData = openssl_encrypt($concessionaires_id, 'aes-256-cbc', $encryptionKey, 0, $iv);
    $data[] = [
        'profile' => '
            <div class="d-flex justify-content-center align-items-center">
                <a href="' . $profileImagePath . '" data-lightbox="profile-pic" data-title="' . $row['full_name'] . ' ' . $row['concessionaires_id'] . '">
                    <img class="mx-auto rounded" src="' . $profileImagePath . '" alt="Profile Picture" style="width: 40px; height: 40px; object-fit: cover;">
                </a>
            </div>',
        'name' => $row['full_name'],
        'address' => $row['billing_address'],
        'contact_info' => $row['contact_no'],
        'accounts_info' => $row['accounts_info'] ?: 'No Accounts',
        'action' => '
<div class="d-flex flex-column flex-md-row gap-2">

    <a href="edit-concessionaires.php?title=Edit Concessionaire&id=' . urlencode($encryptedData) . '" 
       class="btn btn-sm btn-primary px-2 py-1">
        <i class="fa-solid fa-user-pen"></i>
        <span class="d-none d-md-inline"> Profile</span>
    </a>

    <a href="edit-concessionaires-accounts.php?title=Accounts&id=' . urlencode($encryptedData) . '" 
       class="btn btn-sm btn-success px-2 py-1 ml-1">
        <i class="fa-solid fa-gauge"></i>
        <span class="d-none d-md-inline"> Accounts</span>
    </a>

    <div class="dropdown ml-1">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle status-btn px-2 py-1"
            type="button"
            data-toggle="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-check-big-icon lucide-square-check-big"><path d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344"/><path d="m9 11 3 3L22 4"/></svg> Active
        </button>

        <div class="dropdown-menu">
            <a class="dropdown-item update-status"
               href="#"
               data-id="' . $encryptedData . '"
               data-status="Temporary Disconnected">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-alert-icon lucide-badge-alert"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>Temporary
            </a>
            <a class="dropdown-item update-status"
               href="#"
               data-id="' . $encryptedData . '"
               data-status="Disconnected">
               Disconnected
            </a>
        </div>
    </div>

</div>
'


    ];
}

// Get total records count
$totalRecordsQuery = "
    SELECT COUNT(DISTINCT ct.concessionaires_id) AS total 
    FROM `concessionaires` ct
    LEFT JOIN `meters` m ON m.concessionaires_id = ct.concessionaires_id AND m.deleted = 0
    WHERE ct.deleted = 0
";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

// Prepare JSON response for DataTables
$response = [
    "draw" => intval($draw),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords,
    "data" => $data
];

echo json_encode($response);

// Close the database connection
mysqli_close($con);
?>
