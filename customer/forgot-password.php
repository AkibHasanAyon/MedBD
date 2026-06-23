<?php include('../partials-front/menu.php'); ?>

<section class="auth-section">
    <div class="auth-form-container">
        <h2>Forgot Password</h2>
        <p class="auth-subtitle">Enter your email to receive a password reset code</p>

        <?php
        if (isset($_SESSION['forgot-error'])) {
            echo $_SESSION['forgot-error'];
            unset($_SESSION['forgot-error']);
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your registered email" required>
            </div>

            <input type="submit" name="submit" value="Send Reset Code" class="btn-auth">
            
            <div class="auth-link">
                Remember your password? <a href="<?php echo SITEURL; ?>customer/login.php">Login here</a>
            </div>
        </form>
    </div>
</section>

<?php
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $sql = "SELECT full_name FROM tbl_customer WHERE email='$email'";
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $full_name = $row['full_name'];
        
        // Generate OTP
        $otp_code = sprintf("%06d", mt_rand(1, 999999));
        $otp_expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        
        $update_sql = "UPDATE tbl_customer SET otp_code='$otp_code', otp_expires_at='$otp_expires_at' WHERE email='$email'";
        mysqli_query($conn, $update_sql);
        
        // Send Email
        require_once '../config/mailer.php';
        $subject = "MedBD - Password Reset Code";
        $body = "
            <h3>Hi $full_name,</h3>
            <p>You requested a password reset. Your reset code is: <b style='font-size:24px; color:#155e58;'>$otp_code</b></p>
            <p>This code will expire in 15 minutes.</p>
            <p>If you did not request this, please ignore this email.</p>
        ";
        sendMail($email, $full_name, $subject, $body);
        
        $_SESSION['reset-email'] = $email;
        $_SESSION['reset-msg'] = "<div class='auth-message success'>A password reset code has been sent to your email.</div>";
        header('location:' . SITEURL . 'customer/reset-password.php');
        exit();
    } else {
        $_SESSION['forgot-error'] = "<div class='auth-message error'>If that email is registered, a code has been sent.</div>";
        // Do not reveal if email exists or not to prevent enumeration
        header('location:' . SITEURL . 'customer/forgot-password.php');
        exit();
    }
}
?>

<?php include('../partials-front/footer.php'); ?>
