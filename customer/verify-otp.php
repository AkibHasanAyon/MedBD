<?php include('../partials-front/menu.php'); ?>

<?php
if (!isset($_SESSION['verify-email'])) {
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}
$email = $_SESSION['verify-email'];
?>

<section class="auth-section">
    <div class="auth-form-container">
        <h2>Verify Your Email</h2>
        <p class="auth-subtitle">We've sent a 6-digit code to <strong><?php echo htmlspecialchars($email); ?></strong></p>

        <?php
        if (isset($_SESSION['verify-msg'])) {
            echo $_SESSION['verify-msg'];
            unset($_SESSION['verify-msg']);
        }
        if (isset($_SESSION['verify-error'])) {
            echo $_SESSION['verify-error'];
            unset($_SESSION['verify-error']);
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Verification Code</label>
                <input type="text" name="otp_code" placeholder="Enter 6-digit code" required autocomplete="off" maxlength="6">
            </div>

            <input type="submit" name="submit" value="Verify Email" class="btn-auth">
            
            <div class="auth-link">
                <a href="<?php echo SITEURL; ?>customer/resend-otp.php">Resend Code</a>
            </div>
        </form>
    </div>
</section>

<?php
if (isset($_POST['submit'])) {
    $entered_otp = mysqli_real_escape_string($conn, $_POST['otp_code']);
    
    // Check if OTP matches and is not expired
    $sql = "SELECT id, full_name, email FROM tbl_customer WHERE email='$email' AND otp_code='$entered_otp' AND otp_expires_at > NOW()";
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $customer_id = $row['id'];
        $customer_name = $row['full_name'];
        
        // Update user as verified and clear OTP
        $update_sql = "UPDATE tbl_customer SET is_verified=1, otp_code=NULL, otp_expires_at=NULL WHERE id=$customer_id";
        mysqli_query($conn, $update_sql);
        
        // Log them in
        $_SESSION['customer_id'] = $customer_id;
        $_SESSION['customer_name'] = $customer_name;
        $_SESSION['customer_email'] = $email;
        
        unset($_SESSION['verify-email']);
        
        $_SESSION['login-success'] = "<div class='auth-message success'>Email verified successfully! You are now logged in.</div>";
        header('location:' . SITEURL);
        exit();
    } else {
        // Invalid or expired
        $_SESSION['verify-error'] = "<div class='auth-message error'>Invalid or expired verification code.</div>";
        header('location:' . SITEURL . 'customer/verify-otp.php');
        exit();
    }
}
?>

<?php include('../partials-front/footer.php'); ?>
