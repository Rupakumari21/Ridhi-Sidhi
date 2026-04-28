<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$current = basename($_SERVER['PHP_SELF']);
?>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #0d0d0d;
    color: #fff;
}

/* SIDEBAR */
.sidebar {
    width: 240px;
    height: 100vh;
    background: linear-gradient(180deg, #111, #000);
    position: fixed;
    top: 0;
    left: 0;
    padding: 20px;
    box-shadow: 4px 0 15px rgba(0,0,0,0.5);
}

/* PROFILE */
.profile {
    text-align: center;
    margin-bottom: 25px;
}

.profile img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 2px solid gold;
    object-fit: cover;
}

.profile h3 {
    color: gold;
    margin-top: 10px;
}

/* MENU */
.sidebar a {
    display: block;
    color: #ccc;
    padding: 12px;
    margin-bottom: 10px;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: gold;
    color: #000;
    transform: translateX(5px);
}

/* ACTIVE */
.sidebar a.active {
    background: gold;
    color: #000;
    font-weight: bold;
}

/* MAIN CONTENT */
.main-content {
    margin-left: 260px;
    padding: 30px;
}
</style>

<div class="sidebar">

    <div class="profile">
        <img src="../assets/uploads/<?php echo $user['profile_photo'] ?: 'default.png'; ?>">
        <h3><?php echo $user['full_name']; ?></h3>
    </div>

    <a href="dashboard.php" class="<?php echo ($current == 'dashboard.php') ? 'active' : ''; ?>">
        🏠 Dashboard
    </a>

    <a href="my_requests.php" class="<?php echo ($current == 'my_requests.php') ? 'active' : ''; ?>">
        📋 My Requests
    </a>

    <a href="profile.php" class="<?php echo ($current == 'profile.php') ? 'active' : ''; ?>">
        👤 Profile
    </a>

    <a href="../index.php">
        🌐 Visit Site
    </a>

    <a href="../logout.php">
        🚪 Logout
    </a>

</div>