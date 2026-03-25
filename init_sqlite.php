<?php
// init_sqlite.php
include 'config/db.php';

try {
    // Users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        full_name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        role TEXT DEFAULT 'client',
        last_reset_token TEXT DEFAULT NULL,
        token_expiry DATETIME DEFAULT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Contact form submissions table
    $pdo->exec("CREATE TABLE IF NOT EXISTS contact_submissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        phone TEXT NOT NULL,
        email TEXT DEFAULT NULL,
        organization TEXT DEFAULT NULL,
        service TEXT NOT NULL,
        location TEXT NOT NULL,
        message TEXT NOT NULL,
        status TEXT DEFAULT 'new',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Check if admin already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute(['admin@ridhisidhi.com']);
    
    if (!$stmt->fetch()) {
        $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['System Admin', 'admin@ridhisidhi.com', $hashedPassword, 'admin']);
        echo "Admin user created successfully!\n";
    }

    echo "SQLite Tables initialized successfully!\n";
} catch (PDOException $e) {
    die("Database initialization failed: " . $e->getMessage());
}
?>
