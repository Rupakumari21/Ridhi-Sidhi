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
                <form action="delete_enquiry.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this enquiry?');" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $enquiry['id']; ?>">
                    <button type="submit" style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.2); color: #ff5555; padding: 10px 20px; border-radius: 6px; cursor: pointer;">
                        <i class="fas fa-trash"></i> Delete Enquiry
                    </button>
                </form>
                <a href="mailto:<?php echo $enquiry['email']; ?>?subject=Regarding your enquiry at Ridhi Sidhi Security" style="display:inline-block; margin-left:10px; background: rgba(0,255,0,0.1); border: 1px solid rgba(0,255,0,0.2); color: #00ff00; padding: 10px 25px; border-radius: 6px; text-decoration:none;">
                    <i class="fas fa-reply"></i> Reply via Email
                </a>
            </div>
        </div>

    </div>
</body>
</html>
