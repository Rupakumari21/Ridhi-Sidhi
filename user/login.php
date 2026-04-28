<?php
session_start();
include '../config/db.php';

// already login
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {

    if ($password === $user['password'] || password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role']; // 👈 IMPORTANT

        // 🔥 ROLE BASED REDIRECT
        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: dashboard.php");
        }

        exit;
    }
}
    echo "<script>alert('Login Failed');</script>";
}
?>