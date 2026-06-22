<?php
include('config/constants.php');

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer-login-msg'] = "<div class='auth-message error'>Please login to add items to your wishlist.</div>";
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}

if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
    $customer_id = (int)$_SESSION['customer_id'];

    $check_sql = "SELECT id FROM tbl_wishlist WHERE product_id=$product_id AND customer_id=$customer_id";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        $_SESSION['wishlist-msg'] = "<div class='success'>Product is already in your wishlist.</div>";
    } else {
        $insert_sql = "INSERT INTO tbl_wishlist SET product_id=$product_id, customer_id=$customer_id";
        $res = mysqli_query($conn, $insert_sql);
        if ($res == true) {
            $_SESSION['wishlist-msg'] = "<div class='success'>Product added to wishlist successfully.</div>";
        } else {
            $_SESSION['wishlist-msg'] = "<div class='error'>Failed to add product to wishlist.</div>";
        }
    }
}

header('location:' . $_SERVER['HTTP_REFERER']);
exit();
?>
