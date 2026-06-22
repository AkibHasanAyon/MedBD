<?php
include('config/constants.php');

if (!isset($_SESSION['customer_id'])) {
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $wishlist_id = (int)$_GET['id'];
    $customer_id = (int)$_SESSION['customer_id'];

    $sql = "DELETE FROM tbl_wishlist WHERE id=$wishlist_id AND customer_id=$customer_id";
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $_SESSION['wishlist-msg'] = "<div class='success'>Item removed from wishlist.</div>";
    } else {
        $_SESSION['wishlist-msg'] = "<div class='error'>Failed to remove item.</div>";
    }
}

header('location:' . SITEURL . 'wishlist.php');
exit();
?>
