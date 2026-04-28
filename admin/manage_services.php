<?php 
include 'includes/header.php'; 
?> 
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/db.php'; // database connection

// ADD SERVICE
if (isset($_POST['add_service'])) {
    $name = htmlspecialchars($_POST['service_name']);
    $desc = htmlspecialchars($_POST['description']);

    $features = preg_replace('/[✔✓•►➤✅❌☑✗✘]/u', '', $_POST['features']);
$features = preg_replace('/\s+/', ' ', $features); // clean extra spaces
$features = htmlspecialchars($features);

$stmt = $pdo->prepare("INSERT INTO services (service_name, description, features) VALUES (?, ?, ?)");
$stmt->execute([$name, $desc, $features]);

    echo "<script>window.location='manage_services.php';</script>";
exit;
    exit;
}

// DELETE SERVICE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM services WHERE id=?");
    $stmt->execute([$id]);

   echo "<script>window.location='manage_services.php';</script>";
exit;
}
?>

<style>

        body {
            background: #0d0d0d;
            color: #fff;
            font-family: Arial;
            padding: 1px;
        }

        h2 {
            color: #facc15;
        }

        input, textarea {
            width: 300px;
            padding: 10px;
            border-radius: 6px;
            border: none;
            margin-bottom: 10px;
        }

        button {
            background: #facc15;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #333;
        }

        a.delete {
            color: red;
        }

        .admin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.admin-table th {
    color: #888;
    font-weight: 500;
    padding: 15px;
    text-align: left;
}

.admin-table td {
    padding: 15px;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.admin-table tr:hover {
    background: rgba(255,255,255,0.03);
}

.delete-btn {
    color: #ff4d4d;
    text-decoration: none;
    padding: 5px 10px;
    border: 1px solid #ff4d4d;
    border-radius: 6px;
    transition: 0.3s;
}

.delete-btn:hover {
    background: #ff4d4d;
    color: #fff;
}

.admin-table td {
    vertical-align: top;
}

.admin-table td br {
    line-height: 1.8;
}

.edit-btn {
    color: #facc15;
    text-decoration: none;
    padding: 5px 10px;
    border: 1px solid #facc15;
    border-radius: 6px;
    margin-right: 8px;
    transition: 0.3s;
}

.edit-btn:hover {
    background: #facc15;
    color: #000;
}

.modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.7);
}

.modal-content {
    background: #111;
    padding: 20px;
    margin: 100px auto;
    width: 400px;
    border-radius: 10px;
    color: white;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #111;
    border-radius: 10px;
    overflow: hidden;
}

.admin-table th {
    color: #facc15;
    font-weight: 600;
    padding: 15px;
    text-align: left;
    background: #1a1a1a;
}

.admin-table td {
    padding: 15px;
    border-top: 1px solid rgba(255,255,255,0.05);
    vertical-align: top;
}

.admin-table tr:hover {
    background: rgba(255,255,255,0.04);
}

.admin-table th:nth-child(1),
.admin-table td:nth-child(1) {
    width: 60px;
}

.admin-table th:nth-child(2),
.admin-table td:nth-child(2) {
    width: 180px;
}

.admin-table th:nth-child(5),
.admin-table td:nth-child(5) {
    width: 140px;
}
.action-btns {
    display: flex;
    flex-direction: column;  /* 👈 vertical */
    gap: 8px;
    align-items: center;
}

#successBox {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #28a745;
    color: #fff;
    padding: 12px 20px;
    border-radius: 6px;
    font-size: 14px;
    z-index: 9999;
}
#successBox.delete {
    background: #ff4d4d;
}

.successBox {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 20px;
    border-radius: 6px;
    font-size: 14px;
    z-index: 9999;
    color: #fff;
    animation: fadeIn 0.3s ease;
}

/* GREEN for UPDATE */
.successBox.update {
    background: #28a745;
}

/* GREEN for DELETE (same theme as you want) */
.successBox.delete {
    background: #28a745;
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.form-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.admin-form {
    width: 100%;
    max-width: 450px;
    background: #111;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.6);
}

/* inputs full width */
.admin-form input,
.admin-form textarea {
    width: 100%;
    margin-bottom: 12px;
}

.main-content h2 {
    margin-top: 30px;
}

</style>

    <div class="main-content">

<h2>Add New Service</h2>

<div class="form-wrapper">

    <form method="POST" class="admin-form">

        <input type="text" name="service_name" placeholder="Service Name" required>

        <textarea name="description" placeholder="Description"></textarea>

        <textarea name="features" placeholder="Enter features (comma separated)"></textarea>

        <button type="submit" name="add_service">Add Service</button>

    </form>

</div>

<h2>All Services</h2>

<table class="admin-table">
    <th>ID</th>
<th>Service Name</th>
<th>Description</th>
<th>Features</th> 
<th>Action</th>

<?php
$services = $pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll();

if (empty($services)) {
    echo "<tr><td colspan='4'>No services found</td></tr>";
} else {
    foreach ($services as $s) {
?>
    <tr>
        <td><?php echo $s['id']; ?></td>
        <td><?php echo $s['service_name']; ?></td>
        <td><?php echo $s['description']; ?></td>
        <td>
    <?php 
    $features = explode(',', $s['features']);
    foreach ($features as $f) {
        echo htmlspecialchars(trim($f)) . ", ";
    }
    ?>
</td>
       <td class="action-btns">
    <a href="#" class="edit-btn"
       onclick="openEditModal(<?php echo $s['id']; ?>, 
       '<?php echo addslashes($s['service_name']); ?>', 
       '<?php echo addslashes($s['description']); ?>', 
       '<?php echo addslashes($s['features']); ?>')">
       Edit
    </a>

    <a class="delete-btn" href="#" 
   onclick="deleteService(<?php echo $s['id']; ?>)">
   Delete
</a>
</td>
    </tr>
<?php }} ?>

</table>
<div id="editModal" class="modal">
  <div class="modal-content">
    <h3>Edit Service</h3>

    <form id="editForm">
      <input type="hidden" id="edit_id">

      <input type="text" id="edit_name" placeholder="Service Name"><br>
      <textarea id="edit_desc"></textarea><br>
      <textarea id="edit_features"></textarea><br>

      <button type="button" onclick="updateService()">Update</button>
      <button type="button" onclick="closeModal()">Close</button>
    </form>
  </div>
</div>


<script>
function openEditModal(id, name, desc, features) {
    document.getElementById('editModal').style.display = 'block';

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_desc').value = desc;
    document.getElementById('edit_features').value = features;
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

function updateService() {
    let id = document.getElementById('edit_id').value;
    let name = document.getElementById('edit_name').value;
    let desc = document.getElementById('edit_desc').value;
    let features = document.getElementById('edit_features').value;

    fetch('update_service.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}&name=${name}&desc=${desc}&features=${features}`
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {

            document.body.insertAdjacentHTML("beforeend",
               '<div class="successBox update">✔ Service Updated Successfully</div>'
            );

            setTimeout(() => {
                location.reload();
            }, 1000);
        }
    });
}


// ✅ DELETE FUNCTION (ALAG se)
function deleteService(id) {
    if (!confirm("Delete this service?")) return;

    fetch('delete_service.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {

            document.body.insertAdjacentHTML("beforeend",
                '<div class="successBox delete">🗑 Service Deleted Successfully</div>'
            );

            setTimeout(() => {
                location.reload();
            }, 1000);

        } else {
            alert("❌ Delete failed!");
        }
    });
}

</script>
</div>