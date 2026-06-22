<?php include(__DIR__ . '/../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDbd</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style2.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/customer.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>


</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="<?php echo SITEURL; ?>" title="Logo">
                    <img src="<?php echo SITEURL; ?>images/MedBdLogo.png?v=<?php echo time();?>" alt="MEDbd Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                
<style>
/* Style The Dropdown Button */

.dropbtn {
  background-color: transparent;
  color: #155e58;
  padding: 16px;
  font-size: 20px;
  font-weight: bold;
  border: none;
  cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: #155e58;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover 
{
    background-color: #f1f1f1;
    font-weight: bold;

}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
  background-color: transparent;
  color: #15c293;

}
</style>

<div class="dropdown">
  <button class="dropbtn">Menu ≡</button>
  
  <div class="dropdown-content">
    
                
                  
                        <a href="<?php echo SITEURL; ?>">Home</a>
                   
                   
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                   
                        <a href="<?php echo SITEURL; ?>product.php">Products</a>
                   
                        <a href="<?php echo SITEURL; ?>contact.php">Contact</a>
         
  </div>
</div>

<!-- Customer Account Links -->
<div class="dropdown">
  <?php if(isset($_SESSION['customer_id'])): ?>
    <button class="dropbtn"><i class='bx bxs-user-circle'></i> <?php echo htmlspecialchars($_SESSION['customer_name']); ?></button>
    <div class="dropdown-content">
        <a href="<?php echo SITEURL; ?>customer/profile.php">My Profile</a>
        <a href="<?php echo SITEURL; ?>customer/my-orders.php">My Orders</a>
        <a href="<?php echo SITEURL; ?>wishlist.php">Wishlist</a>
        <a href="<?php echo SITEURL; ?>cart.php">Cart
            <?php
                // Show cart count badge
                if(isset($_SESSION['customer_id'])){
                    $cart_sql = "SELECT SUM(qty) as total_items FROM tbl_cart WHERE customer_id=".(int)$_SESSION['customer_id'];
                    $cart_res = mysqli_query($conn, $cart_sql);
                    $cart_row = mysqli_fetch_assoc($cart_res);
                    $cart_count = $cart_row['total_items'] ? $cart_row['total_items'] : 0;
                    if($cart_count > 0){
                        echo "<span class='cart-badge'>$cart_count</span>";
                    }
                }
            ?>
        </a>
        <a href="<?php echo SITEURL; ?>customer/logout.php">Logout</a>
    </div>
  <?php else: ?>
    <button class="dropbtn"><i class='bx bxs-user'></i> Account</button>
    <div class="dropdown-content">
        <a href="<?php echo SITEURL; ?>customer/login.php">Login</a>
        <a href="<?php echo SITEURL; ?>customer/register.php">Register</a>
    </div>
  <?php endif; ?>
</div>

            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->