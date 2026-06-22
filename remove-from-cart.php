<?php
include('config/constants.php');

if (!isset($_SESSION['customer_id'])) {
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}

$customer_id = (int)$_SESSION['customer_id'];

if (isset($_GET['id'])) {
    $cart_id = (int)$_GET['id'];
    
    // Ensure the cart item belongs to the logged-in customer
    $sql = "DELETE FROM tbl_cart WHERE id=$cart_id AND customer_id=$customer_id";
    $res = mysqli_query($conn, $sql);
    
    if ($res == true) {
        $_SESSION['cart-msg'] = "<div class='success'>Item removed from cart.</div>";
    } else {
        $_SESSION['cart-msg'] = "<div class='error'>Failed to remove item.</div>";
    }
}

header('location:' . SITEURL . 'cart.php');
exit();
?>
