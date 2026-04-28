<?php
include '../config/db.php';

// 🔥 AJAX UPDATE (TOP)
if (isset($_POST['request_id'])) {

    $stmt = $pdo->prepare("UPDATE service_requests SET status=? WHERE id=?");
    $stmt->execute([$_POST['status'], $_POST['request_id']]);

    echo "success";
    exit;
}

// HEADER
include 'includes/header.php';

// FILTER VALUES
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

// ✅ MAIN QUERY
$sql = "
SELECT sr.*, u.full_name, s.service_name
FROM service_requests sr
LEFT JOIN users u ON sr.user_id = u.id
LEFT JOIN services s ON sr.service_id = s.id
WHERE 1
";

$params = [];

// 🔍 SEARCH
if (!empty($search)) {
    $sql .= " AND u.full_name LIKE ?";
    $params[] = "%$search%";
}

// 📌 STATUS FILTER
if (!empty($status)) {
    $sql .= " AND sr.status = ?";
    $params[] = $status;
}

// ✅ ORDER LAST
$sql .= " ORDER BY sr.id DESC";

// EXECUTE
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$requests = $stmt->fetchAll();
?>

<h2 style="color:#facc15;">Manage Requests</h2>

<div class="filter-box">

    <input type="text" id="searchInput" placeholder="🔍 Search by user name..." value="<?php echo $search; ?>">

    <select id="statusFilter">
    <option value="">All Status</option>

    <option value="Pending" <?php if($status=='Pending') echo 'selected'; ?>>Pending</option>

    <option value="Approved" <?php if($status=='Approved') echo 'selected'; ?>>Approved</option>

    <option value="Rejected" <?php if($status=='Rejected') echo 'selected'; ?>>Rejected</option>

    <option value="Assigned" <?php if($status=='Assigned') echo 'selected'; ?>>Assigned</option>

    <option value="Scheduled" <?php if($status=='Scheduled') echo 'selected'; ?>>Scheduled</option>

    <option value="Payment Pending" <?php if($status=='Payment Pending') echo 'selected'; ?>>Payment Pending</option>

    <option value="Paid" <?php if($status=='Paid') echo 'selected'; ?>>Paid</option>

    <option value="Completed" <?php if($status=='Completed') echo 'selected'; ?>>Completed</option>
</select>

</div>

<table class="admin-table">
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Service</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php foreach ($requests as $r) { ?>
<tr>
    <td><?php echo $r['id']; ?></td>

    <td><?php echo $r['full_name'] ?? 'Unknown User'; ?></td>

    <td><?php echo $r['service_name'] ?? 'Service Deleted'; ?></td>

    <td>
        <span class="status <?php echo strtolower($r['status']); ?>">
            <?php echo $r['status']; ?>
        </span>
    </td>

   

<td>

<?php if (strtolower($r['status']) == 'pending') { ?>

    <button onclick="updateStatus(<?php echo $r['id']; ?>, 'Approved')" 
            class="approve-btn">
        Approve
    </button>

    <button onclick="updateStatus(<?php echo $r['id']; ?>, 'Rejected')" 
            class="reject-btn">
        Reject
    </button>

<?php } ?>

<?php if (strtolower($r['status']) == 'approved') { ?>
    <a href="assign_guard.php?id=<?php echo $r['id']; ?>" class="action-btn">Assign Guard</a>
<?php } ?>

<?php if (strtolower($r['status']) == 'assigned') { ?>
    <a href="schedule.php?id=<?php echo $r['id']; ?>" class="action-btn">Schedule</a>
<?php } ?>

<?php if (strtolower($r['status']) == 'scheduled') { ?>
    <a href="add_payment.php?id=<?php echo $r['id']; ?>" class="action-btn">Add Payment</a>
<?php } ?>

<?php if (strtolower($r['status']) == 'paid') { ?>
    <span style="color:orange;">Waiting for Feedback</span>
<?php } ?>

<?php if (strtolower($r['status']) == 'completed') { ?>

    <a href="view_feedback.php?id=<?php echo $r['id']; ?>" 
       class="action-btn" style="margin-left:5px;">
       View Feedback
    </a>

<?php } ?>
</td>


</tr>
<?php } ?>

</table>

<script>
function updateStatus(id, status) {

    if (!confirm("Are you sure?")) return;

    fetch('manage_requests.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'request_id=' + id + '&status=' + status
    })
    .then(res => res.text())
    .then(data => {

        if (data.trim() === "success") {

            // ✅ Success Message
            let msg = status === 'Approved' 
                ? "✔ Request Approved" 
                : "❌ Request Rejected";

            let box = document.createElement("div");
            box.innerHTML = msg;

            box.style.position = "fixed";
            box.style.top = "20px";
            box.style.right = "20px";
            box.style.background = "#28a745";
            box.style.color = "#fff";
            box.style.padding = "10px 15px";
            box.style.borderRadius = "6px";
            box.style.zIndex = "9999";

            document.body.appendChild(box);

            // ✅ IMPORTANT FIX: instant reload
            location.reload();
             

        } else {
            alert("Error updating status");  
        }

    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong");
    });
}

// FILTER
const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");

function applyFilter() {
    let search = searchInput.value;
    let status = statusFilter.value;

    let url = `manage_requests.php?search=${search}&status=${status}`;
    window.location.href = url;
}

searchInput.addEventListener("keyup", applyFilter);
statusFilter.addEventListener("change", applyFilter);
</script>

<style>
.approve-btn {
    background: linear-gradient(45deg, #28a745, #34d058);
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

.reject-btn {
    background: linear-gradient(45deg, #dc3545, #ff4d4d);
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

.status.pending { color: #ffc107; }
.status.approved { color: #28a745; }
.status.rejected { color: #dc3545; }

.filter-box {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.filter-box input,
.filter-box select {
    padding: 10px;
    border-radius: 6px;
    border: none;
    background: #111;
    color: #fff;
}

.action-btn {
    display: inline-block;
    background: linear-gradient(45deg, #007bff, #3399ff);
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
    margin-right: 5px;
}

.action-btn:hover {
    background: linear-gradient(45deg, #0056b3, #007bff);
}

</style>