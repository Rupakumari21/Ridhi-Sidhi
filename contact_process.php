<?php
// contact_process.php
include 'config/db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $organization = isset($_POST['organization']) ? trim($_POST['organization']) : '';
    $service = isset($_POST['service']) ? trim($_POST['service']) : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Validation check for each required field
    $required_fields = [
        'name' => 'Full Name',
        'phone' => 'Phone Number',
        'service' => 'Service Required',
        'location' => 'Location / City',
        'message' => 'Message / Requirements'
    ];

    foreach ($required_fields as $field => $label) {
        if (empty($$field)) {
            echo json_encode(['status' => 'error', 'message' => "The $label field is required."]);
            exit;
        }
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
