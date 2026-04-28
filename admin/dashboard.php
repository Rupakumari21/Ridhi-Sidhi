<?php include 'includes/header.php'; ?>

        <?php
        // Get counts
        $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $enquiryCount = $pdo->query("SELECT COUNT(*) FROM contact_submissions")->fetchColumn();
        $totalRequests = $pdo->query("SELECT COUNT(*) FROM service_requests")->fetchColumn();
        $totalServices = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
        // Get latest enquiries
        $latestEnquiries = $pdo->query("SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5")->fetchAll();
        ?>

        <div class="admin-stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3><?php echo $userCount; ?></h3>
                    <p>Total Registered Users</p>
                </div>
            </div>

            <div class="stat-card">
    <div class="stat-icon">
        <i class="fas fa-briefcase"></i>
    </div>
    <div class="stat-info">
        <h3><?php echo $totalServices; ?></h3>
        <p>Total Available Services</p>
    </div>
</div>


            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                <div class="stat-info">
                    <h3><?php echo $enquiryCount; ?></h3>
                    <p>Total Enquiries Received</p>
                </div>
            </div>


            <div class="stat-card">
    <div class="stat-icon">
        <i class="fas fa-clipboard-list"></i>
    </div>
    <div class="stat-info">
        <h3><?php echo $totalRequests; ?></h3>
        <p>Total Service Requests</p>
    </div>
</div>
           
           
        </div>

        <div class="admin-table-container">
            <h2>
                Latest Enquiries
                <a href="enquiries.php" class="btn-view">View All</a>
            </h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Service</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($latestEnquiries)): ?>
                        <tr><td colspan="6" style="text-align: center;">No enquiries found.</td></tr>
                    <?php else: ?>
                        <?php foreach($latestEnquiries as $enquiry): ?>
                        <tr>
                            <td><?php echo date('d-m-Y', strtotime($enquiry['created_at'])); ?></td>
                            <td><?php echo $enquiry['name']; ?></td>
                            <td><?php echo $enquiry['service']; ?></td>
                            <td><?php echo $enquiry['location']; ?></td>
                            <td>
                                <span class="status-badge <?php echo $enquiry['status'] == 'new' ? 'status-new' : 'status-replied'; ?>">
                                    <?php echo $enquiry['status']; ?>
                                </span>
                            </td>
                            <td><a href="enquiry_view.php?id=<?php echo $enquiry['id']; ?>" class="btn-view">View</a></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div> <!-- Close admin-main from header.php -->
</body>
</html>
