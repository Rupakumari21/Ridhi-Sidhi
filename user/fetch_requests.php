<?php
session_start();
include '../config/db.php';

// 🔒 LOGIN CHECK
if (!isset($_SESSION['user_id'])) {
    exit("Login required");
}

$user_id = $_SESSION['user_id'];

// FETCH REQUESTS + SERVICE NAME
$stmt = $pdo->prepare("
    SELECT r.*, s.service_name 
    FROM service_requests r 
    JOIN services s ON r.service_id = s.id 
    WHERE r.user_id=? 
    ORDER BY r.id DESC
");

$stmt->execute([$user_id]);
$requests = $stmt->fetchAll();

// DATA OUTPUT
if (!empty($requests)) {

    foreach ($requests as $r) {
?>

<tr>
    <td style="color:#aaa;"><?php echo $r['id']; ?></td>

    <td style="color:#fff; font-weight:500;">
        <?php echo htmlspecialchars($r['service_name']); ?>
    </td>

    <td>
        <span class="status <?php echo strtolower($r['status']); ?>">
            <?php echo $r['status']; ?>
        </span>
    </td>

    <td style="color:#bbb;">
        <?php echo date("d M Y", strtotime($r['created_at'])); ?>
    </td>
</tr>

<?php 
    }

} else {
    echo "<tr><td colspan='4' class='no-data'>No requests found 😔</td></tr>";
}
?>

<script>
function loadRequests() {
    fetch('fetch_requests.php')
    .then(res => res.text())
    .then(data => {
        document.getElementById("requestTable").innerHTML = data;
    });
}

// first load
loadRequests();

// auto refresh every 3 sec
setInterval(loadRequests, 3000);
</script>