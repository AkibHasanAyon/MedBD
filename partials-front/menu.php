<?php include(__DIR__ . '/../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDbd | Premium Medical E-Commerce</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/customer.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/png" href="<?php echo SITEURL; ?>images/favicon.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<!-- Toast Notification Container -->
<div id="toast-container">
    <?php
    // Generic message handler to convert sessions into Toasts
    $messages = [
        'order-success' => ['type' => 'success', 'icon' => 'bx-check-circle'],
        'order-error' => ['type' => 'error', 'icon' => 'bx-error-circle'],
        'customer-login-msg' => ['type' => 'error', 'icon' => 'bx-error'],
        'wishlist-msg' => ['type' => 'success', 'icon' => 'bx-heart'],
        'cart-msg' => ['type' => 'success', 'icon' => 'bx-cart'],
        'error' => ['type' => 'error', 'icon' => 'bx-error-circle'],
        'success' => ['type' => 'success', 'icon' => 'bx-check-circle']
    ];

    foreach ($messages as $key => $config) {
        if (isset($_SESSION[$key])) {
            // Strip any raw HTML the old system used (like <div class='error'>)
            $msg_clean = strip_tags($_SESSION[$key]);
            if (!empty(trim($msg_clean))) {
                echo "<div class='toast {$config['type']}'><i class='bx {$config['icon']}'></i> <span>{$msg_clean}</span></div>";
            }
            unset($_SESSION[$key]);
        }
    }
    ?>
</div>

<script>
    // Auto-hide toasts after 4 seconds
    setTimeout(() => {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(toast => {
            toast.classList.add('fade-out');
            setTimeout(() => toast.remove(), 300); // Wait for transition
        });
    }, 4000);
</script>

<!-- Navbar -->
<section class="navbar">
    <div class="container">
        <div class="logo">
            <a href="<?php echo SITEURL; ?>" title="Logo">
                <img src="<?php echo SITEURL; ?>images/MedBdLogo.png" alt="MEDbd Logo">
            </a>
        </div>

        <div class="menu">
            <ul>
                <li><a href="<?php echo SITEURL; ?>" class="nav-link"><i class='bx bx-home nav-icon'></i> Home</a></li>
                <li><a href="<?php echo SITEURL; ?>catalog/categories.php" class="nav-link"><i class='bx bx-category nav-icon'></i> Categories</a></li>
                <li><a href="<?php echo SITEURL; ?>catalog/products.php" class="nav-link"><i class='bx bx-store-alt nav-icon'></i> Products</a></li>
                
                <li class="user-dropdown">
                    <?php if(isset($_SESSION['customer_id'])): ?>
                        <button class="user-btn">
                            <i class='bx bxs-user-circle' style="font-size: 20px;"></i>
                            <?php echo htmlspecialchars(explode(' ', $_SESSION['customer_name'])[0]); ?>
                        </button>
                        <div class="dropdown-menu">
                            <a href="<?php echo SITEURL; ?>customer/profile.php"><i class='bx bx-user'></i> My Profile</a>
                            <a href="<?php echo SITEURL; ?>customer/my-orders.php"><i class='bx bx-receipt'></i> My Orders</a>
                            <a href="<?php echo SITEURL; ?>wishlist/"><i class='bx bx-heart'></i> Wishlist</a>
                            <a href="<?php echo SITEURL; ?>cart/"><i class='bx bx-cart'></i> Shopping Cart 
                                <?php
                                    $cart_sql = "SELECT SUM(qty) as total_items FROM tbl_cart WHERE customer_id=".(int)$_SESSION['customer_id'];
                                    $cart_res = mysqli_query($conn, $cart_sql);
                                    if ($cart_res) {
                                        $cart_row = mysqli_fetch_assoc($cart_res);
                                        if ($cart_row['total_items'] > 0) {
                                            echo "<span class='cart-badge'>" . $cart_row['total_items'] . "</span>";
                                        }
                                    }
                                ?>
                            </a>
                            <a href="<?php echo SITEURL; ?>customer/logout.php" style="color: var(--danger);"><i class='bx bx-log-out'></i> Logout</a>
                        </div>
                    <?php else: ?>
                        <button class="user-btn">
                            <i class='bx bx-user'></i> Account
                        </button>
                        <div class="dropdown-menu">
                            <a href="<?php echo SITEURL; ?>customer/login.php"><i class='bx bx-log-in'></i> Login</a>
                            <a href="<?php echo SITEURL; ?>customer/register.php"><i class='bx bx-user-plus'></i> Register</a>
                        </div>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</section>