<?php
include '../config/db.php';

$id = $_GET['id'] ?? 0;

// Update payment status
$pdo->prepare("UPDATE payments SET payment_status='Paid' WHERE request_id=?")
    ->execute([$id]);

// Update request status
$pdo->prepare("UPDATE service_requests SET status='Paid' WHERE id=?")
    ->execute([$id]);

header("Location: my_requests.php");
exit;
?>