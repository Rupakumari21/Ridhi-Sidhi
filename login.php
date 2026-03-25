<?php include 'includes/header.php'; ?>

<body class="auth-only">
    <div class="auth-page">
        <div class="auth-box">
            <h2 id="loginTitle">Login</h2>
            <p class="auth-subtitle" id="loginSubtitle">Access your account</p>

            <div class="role-switch">
                <button type="button" class="role-btn <?php echo (isset($_GET['role']) && $_GET['role'] == 'admin') ? 'active' : ''; ?>" data-role="admin">
                    <i class="fas fa-user-shield"></i> Admin
                </button>
                <button type="button" class="role-btn <?php echo (!isset($_GET['role']) || $_GET['role'] == 'client') ? 'active' : ''; ?>" data-role="client">
                    <i class="fas fa-user"></i> User
                </button>
            </div>

            <form class="auth-form" id="loginForm">
                <input type="hidden" id="loginRole" name="role" value="<?php echo isset($_GET['role']) ? $_GET['role'] : 'client'; ?>">

                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div id="loginMessage" style="margin-top: 15px; text-align: center;"></div>
                
                <button type="submit" class="btn-gold full-btn">Login</button>
            </form>

            <p class="auth-footer">
                Don’t have an account? <a href="signup.php" class="gold">Create one</a>
            </p>
            <p class="auth-footer">
                <a href="forgot-password.php" class="gold">Forgot Password?</a>
            </p>
        </div>
    </div>

<script>
$(document).ready(function() {
    $('.role-btn').click(function() {
        $('.role-btn').removeClass('active');
        $(this).addClass('active');
        $('#loginRole').val($(this).data('role'));
    });

    $('#loginForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $('#loginMessage').html('<p style="color: gold;">Authenticating...</p>');

        $.ajax({
            url: 'login_process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#loginMessage').html('<p style="color: #00ff00;">' + response.message + '</p>');
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                } else {
                    $('#loginMessage').html('<p style="color: #ff0000;">' + response.message + '</p>');
                }
            },
            error: function() {
                $('#loginMessage').html('<p style="color: #ff0000;">An error occurred. Please try again.</p>');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
