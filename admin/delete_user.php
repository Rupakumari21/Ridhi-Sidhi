<?php
// admin/delete_user.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Access denied.");
}
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    
    $id = $_POST['id'];
    
    // Check if the user is not deleting themselves
    if ($id == $_SESSION['user_id']) {
        header("Location: users.php?error=cannot_delete_self");
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$id])) {
            header("Location: users.php?message=user_deleted");
        } else {
            header("Location: users.php?error=delete_failed");
        }
    } catch (PDOException $e) {
        header("Location: users.php?error=" . urlencode($e->getMessage()));
    }
} else {
    header("Location: users.php");
}
?>
