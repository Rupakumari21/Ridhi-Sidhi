<?php include 'includes/header.php'; ?>

<body class="auth-only">
    <div class="auth-page">
        <div class="auth-box">
            <h2 id="signupTitle">Create Account</h2>
            <p class="auth-subtitle" id="signupSubtitle">Register a new account</p>

            <div class="role-switch">
                <button type="button" class="role-btn active" data-role="admin">
                    <i class="fas fa-user-shield"></i> Admin
                </button>
                <button type="button" class="role-btn" data-role="client">
                    <i class="fas fa-user"></i> User
                </button>
            </div>

            <form class="auth-form" id="signupForm">
                <input type="hidden" id="signupRole" name="role" value="admin">

                <div class="form-group">
                    <input type="text" name="full_name" placeholder="Full Name" required>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>

                <button type="submit" class="btn-gold full-btn">Sign Up</button>
            </form>

            <div id="signupMessage" style="margin-top: 15px; text-align: center;"></div>

            <p class="auth-footer">
                Already have an account? <a href="login.php" class="gold">Login</a>
            </p>
        </div>
    </div>

<script>
$(document).ready(function() {
    $('.role-btn').click(function() {
        $('.role-btn').removeClass('active');
        $(this).addClass('active');
        $('#signupRole').val($(this).data('role'));
    });

    $('#signupForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $('#signupMessage').html('<p style="color: gold;">Processing...</p>');

        $.ajax({
            url: 'register_process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#signupMessage').html('<p style="color: #00ff00;">' + response.message + '</p>');
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000);
                } else {
                    $('#signupMessage').html('<p style="color: #ff0000;">' + response.message + '</p>');
                }
            },
            error: function() {
                $('#signupMessage').html('<p style="color: #ff0000;">An error occurred. Please try again.</p>');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
