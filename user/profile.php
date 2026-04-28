<?php
include 'includes/header.php';

$user_id = $_SESSION['user_id'];

// ✅ FETCH USER (VERY IMPORTANT)
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// 🔄 UPDATE PROFILE
if (isset($_POST['update'])) {

    $name = $_POST['full_name'];
    $email = $_POST['email'];

    $photoName = $user['profile_photo']; // default old

    // 📸 FILE UPLOAD
    if (!empty($_FILES['photo']['name'])) {

        $file = $_FILES['photo'];
        $fileName = time() . "_" . $file['name'];
        $target = "../assets/uploads/" . $fileName;

        move_uploaded_file($file['tmp_name'], $target);

        $photoName = $fileName;
    }

    // UPDATE DB
    $stmt = $pdo->prepare("UPDATE users SET full_name=?, email=?, profile_photo=? WHERE id=?");
    $stmt->execute([$name, $email, $photoName, $user_id]);

    echo "<script>alert('Profile Updated Successfully'); window.location='profile.php';</script>";
}
?>

<div class="main-content">

    <h2>👤 My Profile</h2>

    <img src="../assets/uploads/<?php echo $user['profile_photo'] ?: 'default.png'; ?>" 
         width="100" height="100" 
         style="border-radius:50%; margin-bottom:15px;">

    <div class="card">
        <form method="POST" enctype="multipart/form-data">

            <label>Full Name</label><br>
            <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>"><br><br>

            <label>Email</label><br>
            <input type="email" name="email" value="<?php echo $user['email']; ?>"><br><br>

            <label>Profile Photo</label><br>
            <input type="file" name="photo"><br><br>

            <button name="update" class="btn">Update Profile</button>

        </form>
    </div>

</div>

<style>
.card {
    background: #111;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
}

input {
    width: 100%;
    padding: 10px;
    background: #111;
    border: 1px solid #333;
    color: #fff;
    border-radius: 6px;
}

.btn {
    background: gold;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
}

.btn:hover {
    background: #e6c200;
}
</style>