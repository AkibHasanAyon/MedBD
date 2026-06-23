<?php include('../partials-front/menu.php'); ?>

<section class="auth-section">
    <div class="auth-form-container">
        <h2>Create Account</h2>
        <p class="auth-subtitle">Join MedBD for a better shopping experience</p>

        <?php
        if (isset($_SESSION['register-error'])) {
            echo $_SESSION['register-error'];
            unset($_SESSION['register-error']);
        }
        if (isset($_SESSION['register-success'])) {
            echo $_SESSION['register-success'];
            unset($_SESSION['register-success']);
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" placeholder="Enter your phone number" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" placeholder="Enter your delivery address">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create a password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm your password" required>
            </div>

            <input type="submit" name="submit" value="Create Account" class="btn-auth">

            <div class="auth-link">
                Already have an account? <a href="<?php echo SITEURL; ?>customer/login.php">Login here</a>
            </div>
        </form>
    </div>
</section>

<?php
// Process Registration
if (isset($_POST['submit'])) {
    // Get form data
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate
    if (empty($full_name) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['register-error'] = "<div class='auth-message error'>All fields are required.</div>";
        header('location:' . SITEURL . 'customer/register.php');
        exit();
    }

    // Check password match
    if ($password !== $confirm_password) {
        $_SESSION['register-error'] = "<div class='auth-message error'>Passwords do not match.</div>";
        header('location:' . SITEURL . 'customer/register.php');
        exit();
    }

    // Check password length
    if (strlen($password) < 6) {
        $_SESSION['register-error'] = "<div class='auth-message error'>Password must be at least 6 characters.</div>";
        header('location:' . SITEURL . 'customer/register.php');
        exit();
    }

    // Check if email already exists
    $check_sql = "SELECT id FROM tbl_customer WHERE email='$email'";
    $check_res = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_res) > 0) {
        $_SESSION['register-error'] = "<div class='auth-message error'>An account with this email already exists.</div>";
        header('location:' . SITEURL . 'customer/register.php');
        exit();
    }

    // Hash password with bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Generate OTP
    $otp_code = sprintf("%06d", mt_rand(1, 999999));
    $otp_expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    // Insert customer
    $sql = "INSERT INTO tbl_customer SET
        full_name='$full_name',
        email='$email',
        phone='$phone',
        password='$hashed_password',
        address='$address',
        is_verified=0,
        otp_code='$otp_code',
        otp_expires_at='$otp_expires_at'
    ";

    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        // Send OTP Email
        require_once '../config/mailer.php';
        $subject = "MedBD - Verify Your Email Address";
        $body = "
            <h3>Welcome to MedBD, $full_name!</h3>
            <p>Your email verification code is: <b style='font-size:24px; color:#155e58;'>$otp_code</b></p>
            <p>This code will expire in 15 minutes.</p>
            <p>If you didn't create an account with us, you can safely ignore this email.</p>
        ";
        sendMail($email, $full_name, $subject, $body);

        // Save email in session to verify page
        $_SESSION['verify-email'] = $email;
        $_SESSION['verify-msg'] = "<div class='auth-message success'>Registration successful! Please check your email for the verification code.</div>";
        
        header('location:' . SITEURL . 'customer/verify-otp.php');
        exit();
    } else {
        $_SESSION['register-error'] = "<div class='auth-message error'>Failed to create account. Please try again.</div>";
        header('location:' . SITEURL . 'customer/register.php');
        exit();
    }
}
?>

<?php include('../partials-front/footer.php'); ?>
