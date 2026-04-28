<?php
include '../config/db.php';

// 🔥 STATUS UPDATE (GET METHOD)
if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'approve') {
        $pdo->prepare("UPDATE service_requests SET status='Approved' WHERE id=?")->execute([$id]);
    }


// 🔥 Check if request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 🔹 Get data safely
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $desc = htmlspecialchars($_POST['desc']);
    $features = htmlspecialchars($_POST['features']);

    try {
        // 🔹 Prepare query
        $stmt = $pdo->prepare("UPDATE services SET service_name=?, description=?, features=? WHERE id=?");

        // 🔹 Execute
        $stmt->execute([$name, $desc, $features, $id]);

        echo "success";

    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
}

?>