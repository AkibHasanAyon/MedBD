<?php include('../partials-front/menu.php'); ?>
<?php include('login-check.php'); ?>

<?php
// Get customer details
$customer_id = (int)$_SESSION['customer_id'];
$sql = "SELECT * FROM tbl_customer WHERE id=$customer_id";
$res = mysqli_query($conn, $sql);
$customer = mysqli_fetch_assoc($res);
?>

<section class="profile-section">
    <h2><i class='bx bxs-user-circle'></i> My Profile</h2>

    <?php
    if (isset($_SESSION['profile-msg'])) {
        echo $_SESSION['profile-msg'];
        unset($_SESSION['profile-msg']);
    }
    ?>

    <!-- Profile Info Card -->
    <div class="profile-card">
        <h3>Personal Information</h3>

        <form action="" method="POST">
            <div class="profile-info">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($customer['full_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>">
                </div>
            </div>

            <br>
            <input type="hidden" name="update_profile" value="1">
            <input type="submit" name="submit" value="Update Profile" class="btn-auth">
        </form>
    </div>

    <!-- Change Password Card -->
    <div class="profile-card">
        <h3>Change Password</h3>

        <?php
        if (isset($_SESSION['pwd-msg'])) {
            echo $_SESSION['pwd-msg'];
            unset($_SESSION['pwd-msg']);
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" placeholder="Enter current password" required>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" placeholder="Enter new password" required>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            </div>

            <input type="hidden" name="change_password" value="1">
            <input type="submit" name="submit" value="Change Password" class="btn-auth">
        </form>
    </div>

    <!-- Order History Card -->
    <div class="profile-card">
        <h3>Recent Orders</h3>

        <?php
        $order_sql = "SELECT * FROM tbl_order WHERE customer_id=$customer_id ORDER BY order_date DESC LIMIT 10";
        $order_res = mysqli_query($conn, $order_sql);
        $order_count = mysqli_num_rows($order_res);

        if ($order_count > 0) {
        ?>
            <table class="order-history-table">
                <tr>
                    <th>Order #</th>
                    <th>Product</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <?php while ($order = mysqli_fetch_assoc($order_res)): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['product']); ?></td>
                        <td>৳<?php echo $order['total']; ?></td>
                        <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                        <td>
                            <?php
                            $status = $order['status'];
                            $status_class = 'status-ordered';
                            if ($status == 'On Delivery') $status_class = 'status-on-delivery';
                            elseif ($status == 'Delivered') $status_class = 'status-delivered';
                            elseif ($status == 'Cancelled') $status_class = 'status-cancelled';
                            ?>
                            <span class="status-badge <?php echo $status_class; ?>"><?php echo $status; ?></span>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <br>
            <div class="auth-link">
                <a href="<?php echo SITEURL; ?>customer/my-orders.php">View All Orders →</a>
            </div>
        <?php
        } else {
            echo "<p style='color:#888; text-align:center; padding:20px;'>You haven't placed any orders yet.</p>";
        }
        ?>
    </div>
</section>

<?php
// Process Profile Update
if (isset($_POST['update_profile'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Check if email is taken by another user
    $check_sql = "SELECT id FROM tbl_customer WHERE email='$email' AND id != $customer_id";
    $check_res = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_res) > 0) {
        $_SESSION['profile-msg'] = "<div class='auth-message error'>This email is already registered to another account.</div>";
        header('location:' . SITEURL . 'customer/profile.php');
        exit();
    }

    $update_sql = "UPDATE tbl_customer SET
        full_name='$full_name',
        email='$email',
        phone='$phone',
        address='$address'
        WHERE id=$customer_id
    ";

    $update_res = mysqli_query($conn, $update_sql);

    if ($update_res == true) {
        // Update session
        $_SESSION['customer_name'] = $full_name;
        $_SESSION['customer_email'] = $email;

        $_SESSION['profile-msg'] = "<div class='auth-message success'>Profile updated successfully.</div>";
    } else {
        $_SESSION['profile-msg'] = "<div class='auth-message error'>Failed to update profile.</div>";
    }

    header('location:' . SITEURL . 'customer/profile.php');
    exit();
}

// Process Password Change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    $pwd_sql = "SELECT password FROM tbl_customer WHERE id=$customer_id";
    $pwd_res = mysqli_query($conn, $pwd_sql);
    $pwd_row = mysqli_fetch_assoc($pwd_res);

    if (!password_verify($current_password, $pwd_row['password'])) {
        $_SESSION['pwd-msg'] = "<div class='auth-message error'>Current password is incorrect.</div>";
        header('location:' . SITEURL . 'customer/profile.php');
        exit();
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['pwd-msg'] = "<div class='auth-message error'>New passwords do not match.</div>";
        header('location:' . SITEURL . 'customer/profile.php');
        exit();
    }

    if (strlen($new_password) < 6) {
        $_SESSION['pwd-msg'] = "<div class='auth-message error'>Password must be at least 6 characters.</div>";
        header('location:' . SITEURL . 'customer/profile.php');
        exit();
    }

    $hashed_new = password_hash($new_password, PASSWORD_BCRYPT);
    $update_pwd_sql = "UPDATE tbl_customer SET password='$hashed_new' WHERE id=$customer_id";
    $update_pwd_res = mysqli_query($conn, $update_pwd_sql);

    if ($update_pwd_res == true) {
        $_SESSION['pwd-msg'] = "<div class='auth-message success'>Password changed successfully.</div>";
    } else {
        $_SESSION['pwd-msg'] = "<div class='auth-message error'>Failed to change password.</div>";
    }

    header('location:' . SITEURL . 'customer/profile.php');
    exit();
}
?>

<?php include('../partials-front/footer.php'); ?>
