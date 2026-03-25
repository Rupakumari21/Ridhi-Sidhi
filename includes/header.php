<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ridhi Sidhi Security Services | Premium Security Solutions</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .logout-btn { background: #d4af37; color: #000; padding: 5px 15px; border-radius: 5px; }
        .user-info { color: #d4af37; margin-right: 15px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="preloader">
        <div class="loader">
            <div class="loader-line"></div>
            <div class="loader-line"></div>
            <div class="loader-line"></div>
        </div>
    </div>

<header class="header">
    <div class="container">
        <div class="logo-container">
            <a href="index.php" class="logo">
                <img src="assets/images/logo.png" alt="Ridhi Sidhi Security Services" class="logo-img">
                <div class="logo-text">
                    <h1>RIDHI SIDHI <span class="gold">SECURITY SERVICES</span></h1>
                    <p class="tagline">Government Contractor & General Order Suppliers</p>
                </div>
            </a>
        </div>

        <nav class="navbar">
            <div class="menu-overlay"></div>
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="about.php"><i class="fas fa-building"></i> About</a></li>

                <li class="dropdown">
                    <a href="services.php" class="dropdown-toggle" data-dropdown>
                        <i class="fas fa-shield-alt"></i> Services
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="security-guard-services.php"><i class="fas fa-user-shield"></i> Security Guard Services</a></li>
                        <li><a href="manpower-supply.php"><i class="fas fa-users"></i> Manpower Supply</a></li>
                        <li><a href="facility-management.php"><i class="fas fa-hard-hat"></i> Facility Management</a></li>
                        <li><a href="housekeeping-services.php"><i class="fas fa-broom"></i> Housekeeping</a></li>
                        <li><a href="corporate-security.php"><i class="fas fa-building"></i> Corporate Security</a></li>
                        <li><a href="educational-security.php"><i class="fas fa-university"></i> Educational Security</a></li>
                        <li><a href="government-security.php"><i class="fas fa-landmark"></i> Government Security</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="supply.php" class="dropdown-toggle" data-dropdown>
                        <i class="fas fa-box"></i> Supply
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="supply-stationery.php"><i class="fas fa-clipboard"></i> Stationery Items</a></li>
                        <li><a href="supply-cleaning.php"><i class="fas fa-spray-can-sparkles"></i> Cleaning Items</a></li>
                        <li><a href="supply-security-items.php"><i class="fas fa-shield-halved"></i> Security Items</a></li>
                        <li><a href="supply-equipments.php"><i class="fas fa-toolbox"></i> Other Equipments</a></li>
                    </ul>
                </li>

                <li><a href="clients.php"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="contact.php"><i class="fas fa-phone"></i> Contact</a></li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="dropdown user-nav">
                        <a href="#" class="login-btn dropdown-toggle" data-dropdown>
                            <i class="fas fa-user-circle"></i> <?php echo explode(' ', $_SESSION['user_full_name'])[0]; ?>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                <li><a href="admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <?php endif; ?>
                            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="dropdown nav-login">
                        <a href="#" class="login-btn dropdown-toggle" data-dropdown>
                            <i class="fas fa-sign-in-alt"></i> Login
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </a>
                        <ul class="dropdown-menu login-dropdown">
                            <li><a href="login.php?role=admin"><i class="fas fa-user-shield"></i> Admin Login</a></li>
                            <li><a href="login.php?role=client"><i class="fas fa-user"></i> User Login</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </div>
</header>
