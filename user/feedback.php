<?php
include '../config/db.php';
include 'includes/header.php';

// 🔹 Get request id
$id = $_GET['id'] ?? 0;

// 🔹 Submit feedback
if (isset($_POST['submit_feedback'])) {

    $request_id = $_POST['request_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // 🔹 insert feedback
    $stmt = $pdo->prepare("INSERT INTO feedback (request_id, rating, comment) VALUES (?, ?, ?)");
    $stmt->execute([$request_id, $rating, $comment]);

    // 🔹 get guard id
    $stmt2 = $pdo->prepare("SELECT guard_id FROM service_requests WHERE id=?");
    $stmt2->execute([$request_id]);
    $data = $stmt2->fetch();
    $guard_id = $data['guard_id'];

    // 🔹 status completed
    $pdo->prepare("UPDATE service_requests SET status='Completed' WHERE id=?")
        ->execute([$request_id]);

    // 🔥 guard free
    if ($guard_id) {
        $pdo->prepare("UPDATE guards SET status='available' WHERE id=?")
            ->execute([$guard_id]);
    }

    echo "<script>
    alert('Feedback submitted successfully ✅');
    window.location.href='my_requests.php';
</script>";
exit;
}

?>
<div class="main-content">

<div class="feedback-card">

    <h2>⭐ Give Feedback</h2>

    <form method="POST">

        <input type="hidden" name="request_id" value="<?php echo $id; ?>">

        <label>Rating</label>
        <select name="rating" required>
            <option value="">Select Rating</option>
            <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
            <option value="4">⭐⭐⭐⭐ Good</option>
            <option value="3">⭐⭐⭐ Average</option>
            <option value="2">⭐⭐ Poor</option>
            <option value="1">⭐ Very Poor</option>
        </select>

        <label>Comment</label>
        <textarea name="comment" rows="4" placeholder="Write your experience..." required></textarea>

        <button name="submit_feedback">Submit Feedback</button>

    </form>

</div>

</div>


<style>
.main-content {
    margin-left: 260px;
    padding: 40px;
}

/* CARD */
.feedback-card {
    background: linear-gradient(145deg, #111, #1a1a1a);
    padding: 30px;
    border-radius: 15px;
    max-width: 450px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
}

/* TITLE */
.feedback-card h2 {
    color: #facc15;
    margin-bottom: 20px;
}

/* FORM */
.feedback-card label {
    display: block;
    margin-bottom: 5px;
    color: #ccc;
}

.feedback-card select,
.feedback-card textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: none;
    background: #0d1117;
    color: #fff;
}

/* BUTTON */
.feedback-card button {
    width: 100%;
    background: linear-gradient(45deg, #007bff, #3399ff);
    border: none;
    padding: 12px;
    border-radius: 6px;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: 0.3s;
}

.feedback-card button:hover {
    background: linear-gradient(45deg, #0056b3, #007bff);
}
</style>