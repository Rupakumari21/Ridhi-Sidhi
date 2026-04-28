<?php
include '../config/db.php';

$id = $_GET['id'];

// FETCH DATA
$stmt = $pdo->prepare("SELECT * FROM services WHERE id=?");
$stmt->execute([$id]);
$service = $stmt->fetch();

// UPDATE
if (isset($_POST['update_service'])) {
    $name = $_POST['service_name'];
    $desc = $_POST['description'];
    $features = $_POST['features'];

    $stmt = $pdo->prepare("UPDATE services SET service_name=?, description=?, features=? WHERE id=?");
    $stmt->execute([$name, $desc, $features, $id]);

    header("Location: manage_services.php");
    exit;
}
?>

<h2>Edit Service</h2>

<form method="POST">
    <input type="text" name="service_name" value="<?php echo $service['service_name']; ?>"><br><br>

    <textarea name="description"><?php echo $service['description']; ?></textarea><br><br>

    <textarea name="features"><?php echo $service['features']; ?></textarea><br><br>

    <button name="update_service">Update</button>
</form>