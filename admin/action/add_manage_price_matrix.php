<?php
require_once __DIR__ . '';

use Dotenv\Dotenv;

// Load .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// DB connection
$servername = $_ENV['DB_HOST'];
$uname      = $_ENV['DB_USERNAME'];
$pass       = $_ENV['DB_PASSWORD'];
$dbname     = $_ENV['DB_DATABASE'];

$con = mysqli_connect($servername, $uname, $pass, $dbname);

if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Form values
    $classification_id = $_POST['classification_id'];
    $minimum_price     = $_POST['minimum_price'];
    $meter_size_id     = $_POST['meter_size_id'];
    $meter_brand_id    = $_POST['meter_brand_id'];
    $charge_1          = $_POST['charge_1'];
    $charge_2          = $_POST['charge_2'];
    $charge_3          = $_POST['charge_3'];
    $charge_4          = $_POST['charge_4'];
    $charge_5          = $_POST['charge_5'];

    // Get actual names
    $sizeResult = $con->query("SELECT meter_size FROM meter_sizes WHERE meter_size_id = '$meter_size_id'");
    $brandResult = $con->query("SELECT meter_brand FROM meter_brands WHERE meter_brand_id = '$meter_brand_id'");
    $classificationResult = $con->query("SELECT classification FROM classification_settings WHERE classification_id = '$classification_id'");

    $meter_size_name = $sizeResult->fetch_assoc()['meter_size'] ?? '';
    $meter_brand_name = $brandResult->fetch_assoc()['meter_brand'] ?? '';
    $classification_name = $classificationResult->fetch_assoc()['classification'] ?? '';

    // Combine size + brand
    $meter_size = $meter_size_name . ' ' . $meter_brand_name;

    // Insert query
    $stmt = $con->prepare("INSERT INTO manage_price_matrix 
        (classification, minimum_price, meter_size, charge_11_20, charge_21_30, charge_31_40, charge_41_50, charge_51_up)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sdfffffff",
        $classification_name,
        $minimum_price,
        $meter_size,
        $charge_1,
        $charge_2,
        $charge_3,
        $charge_4,
        $charge_5
    );

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Price Matrix added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
}
$con->close();
?>
