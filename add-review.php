<?php
include('config/constants.php');

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer-login-msg'] = "<div class='auth-message error'>Please login to write a review.</div>";
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $product_id = (int)$_POST['product_id'];
    $customer_id = (int)$_SESSION['customer_id'];
    $rating = (int)$_POST['rating'];
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);
    
    // Check if customer has actually purchased this product and it is delivered
    $purchase_sql = "SELECT id FROM tbl_order WHERE customer_id=$customer_id AND product_id=$product_id AND status='Delivered'";
    $purchase_res = mysqli_query($conn, $purchase_sql);
    
    if (mysqli_num_rows($purchase_res) == 0) {
        $_SESSION['review-msg'] = "<div class='error'>You can only review products that have been delivered to you.</div>";
        header('location:' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    
    // Check if customer already reviewed this product
    $check_sql = "SELECT id FROM tbl_review WHERE product_id=$product_id AND customer_id=$customer_id";
    $check_res = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_res) > 0) {
        $_SESSION['review-msg'] = "<div class='error'>You have already reviewed this product.</div>";
    } else {
        $insert_sql = "INSERT INTO tbl_review SET
            product_id=$product_id,
            customer_id=$customer_id,
            rating=$rating,
            review_text='$review_text'
        ";
        
        $res = mysqli_query($conn, $insert_sql);
        
        if ($res == true) {
            $_SESSION['review-msg'] = "<div class='success'>Thank you! Your review has been submitted.</div>";
        } else {
            $_SESSION['review-msg'] = "<div class='error'>Failed to submit review.</div>";
        }
    }
}

header('location:' . $_SERVER['HTTP_REFERER']);
exit();
?>
