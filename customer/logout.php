<?php 
    include('../config/constants.php');

    // Destroy customer session variables
    unset($_SESSION['customer_id']);
    unset($_SESSION['customer_name']);
    unset($_SESSION['customer_email']);

    $_SESSION['customer-login-msg'] = "<div class='auth-message success'>You have been logged out successfully.</div>";

    // Redirect to login page
    header('location:' . SITEURL . 'customer/login.php');
    exit();
?>
