<?php include 'includes/header.php'; ?>

<?php
include '../config/db.php';

$id = $_GET['id'] ?? 0;

// Fetch feedback
$stmt = $pdo->prepare("SELECT * FROM feedback WHERE request_id=?");
$stmt->execute([$id]);
$feedback = $stmt->fetch();
?>
<div class="main-content">

<div class="feedback-card">

    <h2> Feedback Details</h2>

    <?php if($feedback){ ?>

        <div class="rating-box">
            ⭐ Rating: <span><?php echo $feedback['rating']; ?>/5</span>
        </div>

        <div class="comment-box">
            <p><?php echo $feedback['comment']; ?></p>
        </div>

    <?php } else { ?>
        <p class="no-feedback">No feedback given yet 😔</p>
    <?php } ?>

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
    max-width: 500px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
}

/* TITLE */
.feedback-card h2 {
    color: #facc15;
    margin-bottom: 20px;
}

/* RATING */
.rating-box {
    font-size: 18px;
    margin-bottom: 15px;
    color: #ccc;
}

.rating-box span {
    color: #28a745;
    font-weight: bold;
}

/* COMMENT */
.comment-box {
    background: #0d1117;
    padding: 15px;
    border-radius: 10px;
    color: #eee;
}

/* EMPTY */
.no-feedback {
    color: #888;
}
</style>

