<?php
// contact_process.php
include 'config/db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $organization = trim($_POST['organization']);
    $service = trim($_POST['service']);
    $location = trim($_POST['location']);
    $message = trim($_POST['message']);

    // errors array
    if (empty($name) || empty($phone) || empty($service) || empty($location) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, phone, email, organization, service, location, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $phone, $email, $organization, $service, $location, $message])) {
            echo json_encode(['status' => 'success', 'message' => 'Message sent successfully! Our team will contact you soon.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
