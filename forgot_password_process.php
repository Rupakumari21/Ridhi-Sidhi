<?php
// forgot_password_process.php
include 'config/db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Email is required.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            
            // Create a pseudo-random token
            $token = bin2hex(random_bytes(32));
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            $stmt = $pdo->prepare("UPDATE users SET last_reset_token = ?, token_expiry = ? WHERE email = ?");
            $stmt->execute([$token, $expiry, $email]);

            // Placeholder for sending email
            // mail($email, "Password Reset Request", "Your reset link: https://yourdomain.com/reset-password.php?token=" . $token);

            echo json_encode(['status' => 'success', 'message' => 'Password reset link sent to your registered email!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email address not found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
