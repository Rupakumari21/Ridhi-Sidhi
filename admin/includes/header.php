<?php
// admin/includes/header.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php?role=admin");
    exit;
}
include '../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Ridhi Sidhi Security Services</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-sidebar-width: 260px;
            --admin-header-height: 70px;
            --admin-bg-dark: #0a0a0a;
            --admin-bg-card: #141414;
            --gold: #d4af37;
        }

        body.admin-body {
            background-color: var(--admin-bg-dark);
            color: #fff;
            font-family: 'Inter', sans-serif;
            margin: 0;
            display: flex;
        }

        .admin-sidebar {
            width: var(--admin-sidebar-width);
            height: 100vh;
            background: var(--admin-bg-card);
            position: fixed;
            border-right: 1px solid rgba(212, 175, 55, 0.1);
        }

        .admin-sidebar-logo {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .admin-sidebar-logo h2 {
            font-size: 1.2rem;
            color: var(--gold);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .admin-nav {
            padding: 20px 0;
        }

        .admin-nav a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #aaa;
            text-decoration: none;
            transition: 0.3s;
            border-left: 3px solid transparent;
        }

        .admin-nav a i {
            margin-right: 15px;
            width: 20px;
        }

        .admin-nav a:hover, .admin-nav a.active {
            background: rgba(212, 175, 55, 0.05);
            color: var(--gold);
            border-left: 3px solid var(--gold);
        }

        .admin-main {
         margin-left: var(--admin-sidebar-width);
         width: calc(100% - var(--admin-sidebar-width));
        padding: 20px 40px 40px 40px; /* top padding kam */
}

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--admin-bg-card);
            padding: 30px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--gold);
            margin-right: 20px;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 2rem;
            color: #fff;
        }

        .stat-info p {
            margin: 5px 0 0;
            color: #888;
            font-size: 0.9rem;
        }

        .admin-table-container {
            background: var(--admin-bg-card);
            border-radius: 12px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            overflow-x: auto;
        }

        .admin-table-container h2 {
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        table.admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.admin-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #888;
            font-weight: 500;
        }

        table.admin-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #ccc;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-new { background: rgba(212, 175, 55, 0.1); color: var(--gold); }
        .status-replied { background: rgba(0, 255, 0, 0.1); color: #00ff00; }

        .btn-view {
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-view:hover {
            background: var(--gold);
            color: #000;
        }

        /* 🔥 Sidebar Enhancement */
.admin-nav a {
    border-radius: 8px;
    margin: 5px 10px;
    position: relative;
}

/* Hover animation */
.admin-nav a:hover {
    transform: translateX(5px);
}

/* Active glow */
.admin-nav a.active {
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
}

/* Icon animation */
.admin-nav a i {
    transition: 0.3s;
}

.admin-nav a:hover i {
    transform: scale(1.2);
}

/* Sidebar logo glow */
.admin-sidebar-logo h2 {
    text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
}

/* 🔥 Sidebar Enhancement */
.admin-nav a {
    border-radius: 8px;
    margin: 5px 10px;
    position: relative;
}

/* Hover animation */
.admin-nav a:hover {
    transform: translateX(5px);
}

/* Active glow */
.admin-nav a.active {
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
}

/* Icon animation */
.admin-nav a i {
    transition: 0.3s;
}

.admin-nav a:hover i {
    transform: scale(1.2);
}

/* Sidebar logo glow */
.admin-sidebar-logo h2 {
    text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
}
.admin-header {
    margin: 0 0 30px 0;
}
.admin-main {
    margin-top: 0;
    padding-top: 20px;
}
.admin-sidebar {
    top: 0;
    left: 0;
}

.admin-header {
    margin: 0 !important;
    padding: 0 !important;
}

.admin-main {
    padding-top: 0 !important;
}

.admin-stats-grid {
    grid-template-columns: repeat(4, 1fr);
}
.admin-form {
    background: #141414;
    padding: 25px;
    border-radius: 12px;
    width: 350px;
    border: 1px solid rgba(255,255,255,0.05);
}

.admin-form input,
.admin-form textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: none;
    margin-bottom: 12px;
    background: #1a1a1a;
    color: #fff;
}

.admin-form input:focus,
.admin-form textarea:focus {
    outline: 1px solid #d4af37;
}

.admin-form button {
    background: #d4af37;
    color: #000;
    padding: 10px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    font-weight: 600;
}

.admin-form button:hover {
    background: #b8962e;
}

.admin-header {
    position: fixed;
    top: 0;
    left: 260px; /* sidebar width */
    right: 0;
    height: 80px;
    background: #0a0a0a;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 30px;
    z-index: 1000;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}
.admin-main {
    margin-left: 260px;
    padding: 100px 40px 40px 40px; /* 👈 TOP padding important */
}

.btn-view {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 20px;
    border: 1px solid #facc15;
    color: #facc15;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* Hover effect */
.btn-view:hover {
    background: #facc15;
    color: #000;
    box-shadow: 0 0 10px rgba(250, 204, 21, 0.6);
    transform: translateY(-2px);
}

.admin-header {
    position: fixed;
    top: 0;
    left: 260px;
    right: 0;
    height: 80px;
    background: #0a0a0a;
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 0 40px; /* 👈 LEFT + RIGHT spacing */

    z-index: 1000;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.admin-header {
    padding-left: 40px !important;
    padding-right: 40px !important;
}

/* 🔥 SAME AS USER DASHBOARD */
.stat-card {
    background: linear-gradient(145deg, #111, #1c1c1c);
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    border: 1px solid rgba(255,215,0,0.2);
    position: relative;
    overflow: hidden;
    transition: 0.3s;
}

/* ICON */
.stat-card .stat-icon {
    font-size: 28px;
    color: gold;
    margin-bottom: 10px;
}

/* NUMBER */
.stat-card h3 {
    font-size: 28px;
    color: #fff;
}

/* TEXT */
.stat-card p {
    color: #aaa;
}

/* 🔥 HOVER EFFECT (same) */
.stat-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 10px 30px rgba(255,215,0,0.3);
}

/* 🔥 GLOW ANIMATION (same magic) */
.stat-card::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,215,0,0.2), transparent);
    top: -100%;
    left: 0;
    transition: 0.5s;
}

.stat-card:hover::before {
    top: 100%;
}
        
</style>
</head>
<body class="admin-body">
    
    <div class="admin-sidebar">
        <div class="admin-sidebar-logo">
            <h2>Ridhi Sidhi Security Services
        </div>
        <nav class="admin-nav">
            <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="enquiries.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'enquiries.php' ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i> Enquiries
            </a>
            <a href="users.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Users
            </a>
            
             <a href="manage_services.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage_services.php' ? 'active' : ''; ?>">
                <i class="fas fa-cogs"></i>Manage Services
            </a>

            <a href="manage_requests.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage_requests.php' ? 'active' : ''; ?>">
                <i class="fas fa-clipboard-list"></i> Manage Requests
            </a>

            <a href="../index.php">
                <i class="fas fa-external-link-alt"></i> Visit Site
            </a>
            <a href="../logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>

    <div class="admin-main">
        <div class="admin-header">
            <div class="admin-header-left">
                <h1>Welcome, Admin</h1>
                <p style="color: #666;">Here's what's happening today.</p>
            </div>
            <div class="admin-header-right">
                <div style="display: flex; align-items: center; background: #1a1a1a; padding: 10px 20px; border-radius: 30px;">
                    <i class="fas fa-user-circle" style="color: var(--gold); margin-right: 10px; font-size: 1.2rem;"></i>
                    <span style="font-weight: 500;"><?php echo $_SESSION['user_full_name']; ?></span>
                </div>
            </div>
        </div>
