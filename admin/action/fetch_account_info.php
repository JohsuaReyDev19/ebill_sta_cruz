<?php
require '../../db/dbconn.php'; // Adjust path if needed

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = $con->prepare("
    SELECT m.meters_id, m.account_no, CONCAT(c.last_name, ', ', c.first_name) AS account_name
    FROM meters m
    INNER JOIN concessionaires c ON m.concessionaires_id = c.concessionaires_id
    WHERE m.account_no LIKE ? OR c.last_name LIKE ?
");

$searchTerm = "%$search%";
$query->bind_param("ss", $searchTerm, $searchTerm);
$query->execute();
$result = $query->get_result();

$accounts = [];
while ($row = $result->fetch_assoc()) {
    
    $accounts[] = [
        'account_no' => $row['account_no'], 
        'account_name' => $row['account_name'],
        'label' => $row['account_no'] . " - " . $row['account_name'],
        'meters_id' => $row['meters_id']
    ];
}

echo json_encode($accounts);
?>
