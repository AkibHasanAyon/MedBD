<?php 
include('../config/constants.php'); 
include('login-check.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDbd Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">
    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>MEDbd<span style="color: #666; font-size: 16px; font-weight: normal; display: block; margin-top: 5px;">Admin Panel</span></h2>
            </div>
            <div class="sidebar-menu">
                <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                    <i class='bx bx-grid-alt'></i> Dashboard
                </a>
                <a href="manage-admin.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage-admin.php' ? 'active' : ''; ?>">
                    <i class='bx bx-user'></i> Manage Admins
                </a>
                <a href="manage-category.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage-category.php' ? 'active' : ''; ?>">
                    <i class='bx bx-category'></i> Categories
                </a>
                <a href="manage-product.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage-product.php' ? 'active' : ''; ?>">
                    <i class='bx bx-package'></i> Products
                </a>
                <a href="manage-order.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage-order.php' ? 'active' : ''; ?>">
                    <i class='bx bx-cart'></i> Orders
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="main-content">
            <header class="top-header">
                <div style="flex: 1;"></div>
                <div class="user-actions">
                    <a href="logout.php" class="btn-logout"><i class='bx bx-log-out'></i> Logout</a>
                </div>
            </header>