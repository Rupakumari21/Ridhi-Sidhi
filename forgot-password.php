<?php include 'includes/header.php'; ?>

<body class="auth-only">
    <div class="auth-page">
        <div class="auth-box">
            <h2 id="forgotTitle">Forgot Password</h2>
            <p class="auth-subtitle" id="forgotSubtitle">Reset your account password</p>

            <form class="auth-form" id="forgotForm">
                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="Enter your registered email" required>
                </div>

                <div id="forgotMessage" style="margin-top: 15px; text-align: center;"></div>
                
                <button type="submit" class="btn-gold full-btn">Send Reset Link</button>
            </form>

            <p class="auth-footer">
                Remember your password? <a href="login.php" class="gold">Back to Login</a>
            </p>
        </div>
    </div>

<script>
$(document).ready(function() {
    $('#forgotForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $('#forgotMessage').html('<p style="color: gold;">Sending request...</p>');

        $.ajax({
            url: 'forgot_password_process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#forgotMessage').html('<p style="color: #00ff00;">' + response.message + '</p>');
                } else {
                    $('#forgotMessage').html('<p style="color: #ff0000;">' + response.message + '</p>');
                }
            },
            error: function() {
                $('#forgotMessage').html('<p style="color: #ff0000;">An error occurred. Please try again.</p>');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
