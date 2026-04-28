
<?php
include '../config/db.php';

// 🔹 Get request id
$id = $_GET['id'] ?? 0;

// 🔹 Handle form submit
if (isset($_POST['schedule'])) {

    $request_id = $_POST['request_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Update schedule
    $stmt = $pdo->prepare("UPDATE service_requests 
        SET service_date=?, service_time=?, status='Scheduled' 
        WHERE id=?");
    $stmt->execute([$date, $time, $request_id]);

    header("Location: manage_requests.php");
    exit;
}

include 'includes/header.php';
?>



<h2>Schedule Service</h2>

<form method="POST">
    <input type="hidden" name="request_id" value="<?php echo $id; ?>">

    <label>Select Date:</label>
    <input type="date" name="date" required>

    <br><br>

    <label>Select Time:</label>
    <input type="time" name="time" required>

    <br><br>

    <button name="schedule">Schedule</button>
</form>