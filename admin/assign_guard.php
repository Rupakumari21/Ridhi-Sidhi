<?php
include '../config/db.php';

// 🔹 Get ID
$id = $_GET['id'] ?? 0;

// 🔹 FORM SUBMIT (IMPORTANT: header BEFORE HTML)
if (isset($_POST['assign'])) {

    $request_id = $_POST['request_id'];
    $guard_id = $_POST['guard_id'];

    // Assign guard + update status
    $pdo->prepare("UPDATE service_requests 
        SET guard_id=?, status='Assigned' 
        WHERE id=?")
        ->execute([$guard_id, $request_id]);

    // Make guard busy
    $pdo->prepare("UPDATE guards SET status='busy' WHERE id=?")
        ->execute([$guard_id]);

    header("Location: manage_requests.php");
    exit;
}

// 🔹 Fetch available guards
$guards = $pdo->query("SELECT * FROM guards WHERE status='available'")->fetchAll();

// 🔹 UI START
include 'includes/header.php';
?>

<h2>Assign Guard</h2>

<form method="POST">
    <input type="hidden" name="request_id" value="<?php echo $id; ?>">

    <label>Select Guard</label>
    <select name="guard_id" required>
        <option value="">--Select--</option>

        <?php foreach ($guards as $g) { ?>
            <option value="<?php echo $g['id']; ?>">
                <?php echo $g['name']; ?> (<?php echo $g['phone']; ?>)
            </option>
        <?php } ?>

    </select>

    <button name="assign">Assign Guard</button>
</form>

