<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = intval($_POST['id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM services WHERE id=?");
        $stmt->execute([$id]);

        echo "success";

    } catch (PDOException $e) {
        echo "error";
    }
}
?>