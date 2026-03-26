<?php
// config/db.php

// Using 127.0.0.1 instead of localhost for better compatibility on macOS
$host = '127.0.0.1'; 
$dbname = 'ridhi_sidhi_db';
$username = 'root';
$password = 'Shaan@123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    if (strpos($_SERVER['PHP_SELF'], '_process.php') !== false) {
        header('Content-Type: application/json');
        die(json_encode(['status' => 'error', 'message' => "Database connection failed: " . $e->getMessage()]));
    }
    die("Database connection failed: " . $e->getMessage());
}
?>
