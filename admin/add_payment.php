<?php
include '../config/db.php';

$id = $_GET['id'] ?? 0;

// FORM SUBMIT
if (isset($_POST['add_payment'])) {

    $request_id = $_POST['request_id'];
    $amount = $_POST['amount'];

    // ✅ amount save + status change
    $pdo->prepare("UPDATE service_requests 
        SET amount=?, status='Payment Pending' 
        WHERE id=?")
        ->execute([$amount, $request_id]);

    // ✅ payment entry
    $pdo->prepare("INSERT INTO payments (request_id, payment_status) 
        VALUES (?, 'Pending')")
        ->execute([$request_id]);

    header("Location: manage_requests.php");
    exit;
}

include 'includes/header.php';
?>

<h2>Add Payment</h2>

<form method="POST">
    <input type="hidden" name="request_id" value="<?php echo $id; ?>">

    <label>Enter Amount:</label>
    <input type="number" name="amount" required>

    <br><br>

    <button name="add_payment">Save Payment</button>
</form>