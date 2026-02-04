<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Read env variables (CORRECT KEYS)
$servername = $_ENV['DB_HOST'];
$uname      = $_ENV['DB_USERNAME'];
$pass       = $_ENV['DB_PASSWORD'];
$dbname     = $_ENV['DB_DATABASE'];

// Connect
$con = mysqli_connect($servername, $uname, $pass, $dbname);

if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}
?>
