<?php 
include('config/constants.php');

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer-login-msg'] = "<div class='auth-message error'>Please login to add items to your cart.</div>";
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}

$customer_id = (int)$_SESSION['customer_id'];

if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];

    // Check if product is already in cart
    $check_sql = "SELECT id, qty FROM tbl_cart WHERE customer_id=$customer_id AND product_id=$product_id";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        // Product exists in cart, increment quantity
        $row = mysqli_fetch_assoc($check_res);
        $new_qty = $row['qty'] + 1;
        $cart_id = $row['id'];
        
        $update_sql = "UPDATE tbl_cart SET qty=$new_qty WHERE id=$cart_id";
        mysqli_query($conn, $update_sql);
        
        $_SESSION['cart-msg'] = "<div class='success'>Cart updated successfully.</div>";
    } else {
        // Add new product to cart
        $insert_sql = "INSERT INTO tbl_cart SET customer_id=$customer_id, product_id=$product_id, qty=1";
        mysqli_query($conn, $insert_sql);
        
        $_SESSION['cart-msg'] = "<div class='success'>Product added to cart successfully.</div>";
    }
}

// Redirect back to referring page or products page
if (isset($_SERVER['HTTP_REFERER'])) {
    header('location:' . $_SERVER['HTTP_REFERER']);
} else {
    header('location:' . SITEURL . 'product.php');
}
exit();
?>
