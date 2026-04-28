<?php include 'includes/header.php'; ?>

        <?php
        if (!isset($_GET['id'])) {
            header("Location: enquiries.php");
            exit;
        }

        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM contact_submissions WHERE id = ?");
        $stmt->execute([$id]);
        $enquiry = $stmt->fetch();

        if (!$enquiry) {
            echo "<h2>Enquiry not found.</h2>";
            exit;
        }

        // Mark as read if it was new
        if ($enquiry['status'] == 'new') {
            $update = $pdo->prepare("UPDATE contact_submissions SET status = 'read' WHERE id = ?");
            $update->execute([$id]);
        }

        if (isset($_POST['send_reply'])) {
    $reply = $_POST['reply_message'];
    $id = $_GET['id'];

    // Status update
    $pdo->prepare("UPDATE contact_submissions SET status='REPLIED' WHERE id=?")
        ->execute([$id]);

    echo "<script>alert('Reply sent successfully');</script>";
}

// If Gmail reply clicked → mark as replied
if (isset($_GET['reply']) && $_GET['reply'] == 1) {
    $pdo->prepare("UPDATE contact_submissions SET status='replied' WHERE id=?")
        ->execute([$id]);
}
        ?>

        <div style="margin-bottom: 20px;">
            <a href="enquiries.php" style="color: var(--gold); text-decoration: none;"><i class="fas fa-arrow-left"></i> Back to All Enquiries</a>
        </div>

        <div class="admin-table-container" style="max-width: 800px;">
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 20px; margin-bottom: 20px;">
                <h2>Enquiry Details</h2>
                <span class="status-badge <?php echo $enquiry['status'] == 'new' ? 'status-new' : 'status-replied'; ?>">
                    <?php echo $enquiry['status']; ?>
                </span>
            </div>

            <div style="display: grid; grid-template-columns: 200px 1fr; gap: 20px; row-gap: 30px;">
                <div style="color: #666; font-weight: 600;">Full Name:</div>
                <div style="color: #fff; font-size: 1.1rem;"><?php echo htmlspecialchars($enquiry['name']); ?></div>

                <div style="color: #666; font-weight: 600;">Phone Number:</div>
                <div style="color: var(--gold); font-size: 1.1rem; font-weight: 600;"><?php echo htmlspecialchars($enquiry['phone']); ?></div>

                <div style="color: #666; font-weight: 600;">Email Address:</div>
                <div style="color: #fff;"><?php echo htmlspecialchars($enquiry['email']); ?></div>

                <div style="color: #666; font-weight: 600;">Organization:</div>
                <div style="color: #fff;"><?php echo htmlspecialchars($enquiry['organization'] ?: 'N/A'); ?></div>

                <div style="color: #666; font-weight: 600;">Service Required:</div>
                <div style="color: #d4af37; background: rgba(212,175,55,0.1); display: inline-block; padding: 5px 15px; border-radius: 4px;"><?php echo htmlspecialchars($enquiry['service']); ?></div>

                <div style="color: #666; font-weight: 600;">Location:</div>
                <div style="color: #fff;"><?php echo htmlspecialchars($enquiry['location']); ?></div>

                <div style="color: #666; font-weight: 600;">Message Content:</div>
                <div style="color: #ccc; line-height: 1.6; background: rgba(255,255,255,0.02); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.03);">
                    <?php echo nl2br(htmlspecialchars($enquiry['message'])); ?>
                </div>

                <div style="color: #666; font-weight: 600;">Submitted On:</div>
                <div style="color: #888;"><?php echo date('d F Y, H:i A', strtotime($enquiry['created_at'])); ?></div>
            </div>

            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
<a href="enquiry_view.php?id=<?php echo $enquiry['id']; ?>&reply=1" 
   onclick="window.open('https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo $enquiry['email']; ?>&su=Reply to your enquiry&body=Hello','_blank')"
   style="background:#0f5132; color:#00ff88; padding:10px 20px; border-radius:6px; text-decoration:none;">
   📧 Reply via Gmail
</a>
            </div>
        </div>

    </div>
</body>
</html>
