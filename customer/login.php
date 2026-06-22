<?php include('../partials-front/menu.php'); ?>

<section class="auth-section">
    <div class="auth-form-container">
        <h2>Welcome Back</h2>
        <p class="auth-subtitle">Login to your MedBD account</p>

        <?php
        if (isset($_SESSION['customer-login-msg'])) {
            echo $_SESSION['customer-login-msg'];
            unset($_SESSION['customer-login-msg']);
        }
        if (isset($_SESSION['customer-login-error'])) {
            echo $_SESSION['customer-login-error'];
            unset($_SESSION['customer-login-error']);
        }
        if (isset($_SESSION['register-success'])) {
            echo $_SESSION['register-success'];
            unset($_SESSION['register-success']);
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <input type="submit" name="submit" value="Login" class="btn-auth">

            <div class="auth-link">
                Don't have an account? <a href="<?php echo SITEURL; ?>customer/register.php">Register here</a>
            </div>
        </form>
    </div>
</section>

<?php
// Process Login
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Get customer by email
    $sql = "SELECT * FROM tbl_customer WHERE email='$email'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($res);

        // Verify password (bcrypt)
        if (password_verify($password, $row['password'])) {
            // Login success
            $_SESSION['customer_id'] = $row['id'];
            $_SESSION['customer_name'] = $row['full_name'];
            $_SESSION['customer_email'] = $row['email'];

            header('location:' . SITEURL);
            exit();
        } else {
            // Wrong password
            $_SESSION['customer-login-error'] = "<div class='auth-message error'>Incorrect email or password.</div>";
            header('location:' . SITEURL . 'customer/login.php');
            exit();
        }
    } else {
        // User not found
        $_SESSION['customer-login-error'] = "<div class='auth-message error'>Incorrect email or password.</div>";
        header('location:' . SITEURL . 'customer/login.php');
        exit();
    }
}
?>

<?php include('../partials-front/footer.php'); ?>
