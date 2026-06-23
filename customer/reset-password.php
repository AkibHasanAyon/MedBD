<?php include('../partials-front/menu.php'); ?>

<?php
if (!isset($_SESSION['reset-email'])) {
    header('location:' . SITEURL . 'customer/forgot-password.php');
    exit();
}
$email = $_SESSION['reset-email'];
?>

<section class="auth-section">
    <div class="auth-form-container">
        <h2>Reset Password</h2>
        <p class="auth-subtitle">Enter the 6-digit code sent to <strong><?php echo htmlspecialchars($email); ?></strong></p>

        <?php
        if (isset($_SESSION['reset-msg'])) {
            echo $_SESSION['reset-msg'];
            unset($_SESSION['reset-msg']);
        }
        if (isset($_SESSION['reset-error'])) {
            echo $_SESSION['reset-error'];
            unset($_SESSION['reset-error']);
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Reset Code</label>
                <input type="text" name="otp_code" placeholder="Enter 6-digit code" required autocomplete="off" maxlength="6">
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" placeholder="Enter new password" required>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            </div>

            <input type="submit" name="submit" value="Reset Password" class="btn-auth">
            
            <div class="auth-link">
                <a href="<?php echo SITEURL; ?>customer/login.php">Back to Login</a>
            </div>
        </form>
    </div>
</section>

<?php
if (isset($_POST['submit'])) {
    $entered_otp = mysqli_real_escape_string($conn, $_POST['otp_code']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($new_password !== $confirm_password) {
        $_SESSION['reset-error'] = "<div class='auth-message error'>Passwords do not match.</div>";
        header('location:' . SITEURL . 'customer/reset-password.php');
        exit();
    }
    
    if (strlen($new_password) < 6) {
        $_SESSION['reset-error'] = "<div class='auth-message error'>Password must be at least 6 characters.</div>";
        header('location:' . SITEURL . 'customer/reset-password.php');
        exit();
    }
    
    // Check if OTP matches and is not expired
    $sql = "SELECT id FROM tbl_customer WHERE email='$email' AND otp_code='$entered_otp' AND otp_expires_at > NOW()";
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $customer_id = $row['id'];
        
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        
        // Update password and clear OTP. Also ensure is_verified is 1 just in case they used reset to verify.
        $update_sql = "UPDATE tbl_customer SET password='$hashed_password', is_verified=1, otp_code=NULL, otp_expires_at=NULL WHERE id=$customer_id";
        mysqli_query($conn, $update_sql);
        
        unset($_SESSION['reset-email']);
        
        $_SESSION['customer-login-msg'] = "<div class='auth-message success'>Password reset successfully! You can now log in.</div>";
        header('location:' . SITEURL . 'customer/login.php');
        exit();
    } else {
        // Invalid or expired
        $_SESSION['reset-error'] = "<div class='auth-message error'>Invalid or expired reset code.</div>";
        header('location:' . SITEURL . 'customer/reset-password.php');
        exit();
    }
}
?>

<?php include('../partials-front/footer.php'); ?>
