<?php 
include('../config/constants.php');

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer-login-msg'] = "<div class='auth-message error'>Please login to add items to your cart.</div>";
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}

$customer_id = (int)$_SESSION['customer_id'];

if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];

    // Check available stock first
    $stock_res = mysqli_query($conn, "SELECT stock_qty FROM tbl_product WHERE id=$product_id AND active='Yes'");
    if ($stock_row = mysqli_fetch_assoc($stock_res)) {
        $stock_available = (int)$stock_row['stock_qty'];
        if ($stock_available <= 0) {
            $_SESSION['cart-msg'] = "<div class='error text-center' style='background:#fef2f2; color:#dc2626; border:1px solid #f87171; padding:10px; border-radius:6px; margin:10px 0;'>Sorry, this product is currently out of stock.</div>";
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('location:' . $_SERVER['HTTP_REFERER']);
            } else {
                header('location:' . SITEURL . 'catalog/products.php');
            }
            exit();
        }
    } else {
        header('location:' . SITEURL . 'catalog/products.php');
        exit();
    }

    // Check if product is already in cart
    $check_sql = "SELECT id, qty FROM tbl_cart WHERE customer_id=$customer_id AND product_id=$product_id";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        // Product exists in cart, check quantity limit before incrementing
        $row = mysqli_fetch_assoc($check_res);
        $new_qty = $row['qty'] + 1;
        $cart_id = $row['id'];
        
        if ($new_qty > $stock_available) {
            $_SESSION['cart-msg'] = "<div class='error text-center' style='background:#fef2f2; color:#dc2626; border:1px solid #f87171; padding:10px; border-radius:6px; margin:10px 0;'>Cannot add more units to cart. Only $stock_available item(s) left in stock!</div>";
        } else {
            $update_sql = "UPDATE tbl_cart SET qty=$new_qty WHERE id=$cart_id";
            mysqli_query($conn, $update_sql);
            $_SESSION['cart-msg'] = "<div class='success text-center'>Cart updated successfully.</div>";
        }
    } else {
        // Add new product to cart
        $insert_sql = "INSERT INTO tbl_cart SET customer_id=$customer_id, product_id=$product_id, qty=1";
        mysqli_query($conn, $insert_sql);
        
        $_SESSION['cart-msg'] = "<div class='success text-center'>Product added to cart successfully.</div>";
    }
}

// Redirect back to referring page or products page
if (isset($_SERVER['HTTP_REFERER'])) {
    header('location:' . $_SERVER['HTTP_REFERER']);
} else {
    header('location:' . SITEURL . 'catalog/products.php');
}
exit();
?>
