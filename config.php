<?php

// Include Composer's autoload file
require_once __DIR__ . '/vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Access environment variables
// $encryptionKey = $_ENV['ENCRYPTION_KEY'];
// $iv = $_ENV['IV'];

$encryptionKey = 'my_super_secret_key_32_chars'; // 32 chars recommended
$iv = '1234567890123456'; // EXACTLY 16 characters

?>