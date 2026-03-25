<?php
// admin/delete_enquiry.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Access denied.");
}
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    
    $id = $_POST['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM contact_submissions WHERE id = ?");
        if ($stmt->execute([$id])) {
            header("Location: enquiries.php?message=enquiry_deleted");
        } else {
            header("Location: enquiries.php?error=delete_failed");
        }
    } catch (PDOException $e) {
        header("Location: enquiries.php?error=" . urlencode($e->getMessage()));
    }
} else {
    header("Location: enquiries.php");
}
?>
