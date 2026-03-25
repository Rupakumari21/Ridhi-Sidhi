<?php include 'includes/header.php'; ?>

        <?php
        $users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
        ?>

        <div class="admin-table-container">
            <h2>
                Manage Users
                <span>Total: <?php echo count($users); ?></span>
            </h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" style="text-align: center;">No users found.</td></tr>
                    <?php else: ?>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['full_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td>
                                <span class="status-badge <?php echo $user['role'] == 'admin' ? 'status-new' : 'status-replied'; ?>" style="background: <?php echo $user['role'] == 'admin' ? 'rgba(212,175,55,0.1)' : 'rgba(0,100,255,0.1)'; ?>; color: <?php echo $user['role'] == 'admin' ? '#d4af37' : '#00aaff'; ?>;">
                                    <?php echo $user['role']; ?>
                                </span>
                            </td>
                            <td><?php echo date('d-m-Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <?php if ($user['email'] !== $_SESSION['user_email']): ?>
                                <form action="delete_user.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" style="color:#ff5555; background:none; border:none; cursor:pointer;"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                                <?php else: ?>
                                <span style="color: #666; font-size: 0.8rem;">(Logged in)</span>
                                <?php endif; ?>
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
