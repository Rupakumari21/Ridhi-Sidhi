<?php 
include 'includes/header.php';

// 🔒 LOGIN CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// total services
$total_services = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();

// total requests by user
$stmt = $pdo->prepare("SELECT COUNT(*) FROM service_requests WHERE user_id=?");
$stmt->execute([$user_id]);
$total_requests = $stmt->fetchColumn();

// pending requests
$stmt = $pdo->prepare("SELECT COUNT(*) FROM service_requests WHERE user_id=? AND status='pending'");
$stmt->execute([$user_id]);
$pending_requests = $stmt->fetchColumn();

// completed requests
$stmt = $pdo->prepare("SELECT COUNT(*) FROM service_requests WHERE user_id=? AND status='completed'");
$stmt->execute([$user_id]);
$completed_requests = $stmt->fetchColumn();

// services data
$services = $pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    padding: 20px;
}

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

/* MAIN */
.main {
    margin-left: 260px;
    padding: 25px;
}

/* CARD */
.card {
    background: linear-gradient(145deg, #111, #1a1a1a);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.5);
}

/* GRID */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

/* SERVICE CARD */
.service {
    background: #111;
    padding: 18px;
    border-radius: 15px;
    border: 1px solid rgba(255,215,0,0.2);
    transition: 0.3s;
    position: relative;
    overflow: hidden;
}

.service:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 10px 25px rgba(255,215,0,0.3);
}

.service h4 {
    color: gold;
}

/* BUTTON */
.btn {
    margin-top: 10px;
    display: inline-block;
    padding: 8px 14px;
    border: 1px solid gold;
    color: gold;
    text-decoration: none;
    border-radius: 6px;
    transition: 0.3s;
}

.btn:hover {
    background: gold;
    color: #000;
}

.stat-card {
    background: linear-gradient(145deg, #111, #1a1a1a);
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    border: 1px solid rgba(255,215,0,0.2);
    transition: 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(255,215,0,0.3);
}

.stat-card h3 {
    font-size: 28px;
    color: gold;
    margin-bottom: 5px;
}

.stat-card p {
    color: #aaa;
}

/* ROW FIX (1 LINE ME 4 CARDS) */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

/* CARD DESIGN */
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
.stat-card .icon {
    font-size: 28px;
    color: gold;
    margin-bottom: 10px;
}

/* NUMBER */
.stat-card h3 {
    font-size: 28px;
    color: #fff;
    margin: 5px 0;
}

/* TEXT */
.stat-card p {
    color: #aaa;
}

/* HOVER EFFECT 🔥 */
.stat-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 10px 30px rgba(255,215,0,0.3);
}

/* GLOW EFFECT */
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

@media(max-width: 768px){
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
</head>

<body>


<!-- MAIN -->
<div class="main">

    <!-- USER -->
    <div class="card">
        <h3>
Welcome, <?php echo isset($user['full_name']) ? $user['full_name'] : 'User'; ?> 👋
</h3>

<p><?php echo $user['email']; ?></p>
    </div>

    <div class="stats-row">

    <div class="stat-card">
        <div class="icon"><i class="fas fa-layer-group"></i></div>
        <h3><?php echo $total_services; ?></h3>
        <p>Total Services</p>
    </div>

    <div class="stat-card">
        <div class="icon"><i class="fas fa-file-alt"></i></div>
        <h3><?php echo $total_requests; ?></h3>
        <p>My Requests</p>
    </div>

    <div class="stat-card">
        <div class="icon"><i class="fas fa-clock"></i></div>
        <h3><?php echo $pending_requests; ?></h3>
        <p>Pending</p>
    </div>

    <div class="stat-card">
        <div class="icon"><i class="fas fa-check-circle"></i></div>
        <h3><?php echo $completed_requests; ?></h3>
        <p>Completed</p>
    </div>

</div>

    <!-- SERVICES -->
    <div class="card">
        <h3>Available Services</h3>

        <div class="grid">
        <?php foreach ($services as $s) { ?>
           <div class="service">
    <h4><?php echo $s['service_name']; ?></h4>

    <p><?php echo $s['description']; ?></p>

    <?php 
    $features = array_filter(array_map('trim', explode(',', $s['features'])));
    ?>

    <small style="color:#aaa;">
        <?php echo implode(', ', $features); ?>
    </small>

    <br><br>

    <a href="book_service.php?id=<?php echo $s['id']; ?>" class="btn">
        Request Service
    </a>
</div>
        <?php } ?>
        </div>

    </div>

</div>

</body>
</html>