<?php
include 'includes/header.php';

$user_id = $_SESSION['user_id'];

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

// ✅ QUERY
$sql = "
SELECT sr.*, s.service_name 
FROM service_requests sr
LEFT JOIN services s ON sr.service_id = s.id
WHERE sr.user_id = ?
";

$params = [$user_id];

// 🔍 SEARCH
if (!empty($search)) {
    $sql .= " AND s.service_name LIKE ?";
    $params[] = "%$search%";
}

// 📌 STATUS FILTER
if (!empty($status)) {
    $sql .= " AND sr.status = ?";
    $params[] = $status;
}

// ORDER
$sql .= " ORDER BY sr.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$requests = $stmt->fetchAll();
?>

<div class="main-content">

    <h2 class="page-title">📋 My Service Requests</h2>

    <!-- 🔍 FILTER -->
    <div class="filter-box">
        <input type="text" id="searchInput" placeholder="Search service..." value="<?php echo $search; ?>">
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

    <div class="request-card">

        <table class="request-table">
            <tr>
                <th>ID</th>
                <th>Service</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php if (!empty($requests)) { ?>
                <?php foreach ($requests as $r) { ?>
                <tr>

                    <td><?php echo $r['id']; ?></td>

                    <td><?php echo $r['service_name'] ?? 'Service Deleted'; ?></td>

                    <td>
                        <span class="status <?php echo strtolower($r['status']); ?>">
                            <?php echo $r['status']; ?>
                        </span>
                    </td>

                    <td><?php echo date("d M Y", strtotime($r['created_at'])); ?></td>

                    <!-- ✅ ACTION COLUMN FIXED -->
                    <td class="action-cell">

                        <?php if(strtolower($r['status']) == 'payment pending'){ ?>
                            <a href="pay.php?id=<?php echo $r['id']; ?>" class="action-btn">
                                Pay Now
                            </a>
                        <?php } ?>
<?php if(strtolower($r['status']) == 'paid'){ ?>

    <?php
    $stmt2 = $pdo->prepare("SELECT id FROM feedback WHERE request_id=?");
    $stmt2->execute([$r['id']]);
    $feedback = $stmt2->fetch();
    ?>

    <?php if($feedback){ ?>
        <span style="color:lightgreen; font-weight:bold;">Done ✅</span>
    <?php } else { ?>
        <a href="feedback.php?id=<?php echo $r['id']; ?>" class="action-btn">
            Give Feedback
        </a>
    <?php } ?>

<?php } ?>

<?php if(strtolower($r['status']) == 'completed'){ ?>
    <span style="color:lightgreen; font-weight:bold;">Done ✅</span>
<?php } ?>

                    </td>

                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5" class="no-data">No requests found 😔</td>
                </tr>
            <?php } ?>

        </table>

    </div>

</div>

<!-- 🔥 FILTER SCRIPT -->
<script>
const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");

function applyFilter() {
    let search = searchInput.value;
    let status = statusFilter.value;

    let url = `my_requests.php?search=${search}&status=${status}`;
    window.location.href = url;
}

searchInput.addEventListener("keyup", applyFilter);
statusFilter.addEventListener("change", applyFilter);
</script>

<style>
.main-content {
    margin-left: 260px;
    padding: 30px;
}

.page-title {
    font-size: 26px;
    font-weight: 600;
    margin-bottom: 20px;
}

/* FILTER */
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

/* CARD */
.request-card {
    background: linear-gradient(145deg, #111, #1a1a1a);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
}

/* TABLE */
.request-table {
    width: 100%;
    border-collapse: collapse;
}

.request-table th {
    text-align: left;
    padding: 15px;
    color: #facc15;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.request-table td {
    padding: 15px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    color: #eee;
}

.request-table tr:hover {
    background: rgba(255,255,255,0.03);
}

/* STATUS */
.status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

.pending { background: rgba(255,193,7,0.15); color: #ffc107; }
.approved { background: rgba(40,167,69,0.15); color: #28a745; }
.rejected { background: rgba(220,53,69,0.15); color: #dc3545; }

/* ACTION ALIGNMENT */
.action-cell {
   
    align-items: center;
    gap: 8px;
}

/* BUTTON STYLE */
.action-btn {
    background: linear-gradient(45deg, #007bff, #3399ff);
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 13px;
}

/* EMPTY */
.no-data {
    text-align: center;
    padding: 20px;
    color: #888;
}
</style>