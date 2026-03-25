<?php include 'includes/header.php'; ?>

        <?php
        $enquiries = $pdo->query("SELECT * FROM contact_submissions ORDER BY created_at DESC")->fetchAll();
        ?>

        <div class="admin-table-container">
            <h2>
                All Enquiries
                <span>Total: <?php echo count($enquiries); ?></span>
            </h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email / Phone</th>
                        <th>Service</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($enquiries)): ?>
                        <tr><td colspan="7" style="text-align: center;">No enquiries found.</td></tr>
                    <?php else: ?>
                        <?php foreach($enquiries as $enquiry): ?>
                        <tr>
                            <td><?php echo date('d-M-Y H:i', strtotime($enquiry['created_at'])); ?></td>
                            <td><?php echo $enquiry['name']; ?></td>
                            <td>
                                <div><?php echo $enquiry['email']; ?></div>
                                <div style="font-size: 0.8rem; color: #888;"><?php echo $enquiry['phone']; ?></div>
                            </td>
                            <td><?php echo $enquiry['service']; ?></td>
                            <td><?php echo $enquiry['location']; ?></td>
                            <td>
                                <span class="status-badge <?php echo $enquiry['status'] == 'new' ? 'status-new' : 'status-replied'; ?>">
                                    <?php echo $enquiry['status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="enquiry_view.php?id=<?php echo $enquiry['id']; ?>" class="btn-view">View Detail</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
