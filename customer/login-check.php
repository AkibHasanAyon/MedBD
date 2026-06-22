<?php 
    // Authorization - Access Control for Customer Pages
    // Check whether the customer is logged in or not 

    if(!isset($_SESSION['customer_id'])){
        // Customer is not logged in
        // Redirect to login page with message
        $_SESSION['customer-login-msg'] = "<div class='auth-message error'>Please login to access this page.</div>";
        // Redirect to login page 
        header('location:'.SITEURL.'customer/login.php');
        exit();
    }
?>
