<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$service_id = $_GET['id'];

// insert request
$stmt = $pdo->prepare("INSERT INTO service_requests (user_id, service_id) VALUES (?, ?)");
$stmt->execute([$user_id, $service_id]);

echo "<script>
alert('✅ Service Requested Successfully!');
window.location='dashboard.php';
</script>";