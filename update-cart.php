<?php
include('config/constants.php');

if (!isset($_SESSION['customer_id'])) {
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}

$customer_id = (int)$_SESSION['customer_id'];

if (isset($_POST['update'])) {
    $cart_id = (int)$_POST['cart_id'];
    $qty = (int)$_POST['qty'];
    
    if ($qty < 1) {
        $qty = 1; // Minimum 1
    }
    
    // Ensure the cart item belongs to the logged-in customer
    $sql = "UPDATE tbl_cart SET qty=$qty WHERE id=$cart_id AND customer_id=$customer_id";
    $res = mysqli_query($conn, $sql);
    
    if ($res == true) {
        $_SESSION['cart-msg'] = "<div class='success'>Cart updated successfully.</div>";
    } else {
        $_SESSION['cart-msg'] = "<div class='error'>Failed to update cart.</div>";
    }
}

header('location:' . SITEURL . 'cart.php');
exit();
?>
