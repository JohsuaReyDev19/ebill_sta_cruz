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
            <a href="#" 
            class="btn btn-sm btn-primary shadow-sm open-edit-modal"
            data-url="edit-concessionaires.php?title=Edit Concessionaire&id=' . urlencode($encryptedData) . '">
            <i class="fa-solid fa-user-pen"></i> Profile
            </a>

            <a href="edit-concessionaires-accounts.php?title=Accounts&id=' . urlencode($encryptedData) . '" 
            class="btn btn-sm btn-success shadow-sm">
            <i class="fa-solid fa-gauge"></i> Accounts
            </a>
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

