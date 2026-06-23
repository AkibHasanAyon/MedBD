<?php
include('../config/constants.php');

if (isset($_SESSION['verify-email'])) {
    $email = $_SESSION['verify-email'];
    
    // Generate new OTP
    $otp_code = sprintf("%06d", mt_rand(1, 999999));
    $otp_expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    
    $update_sql = "UPDATE tbl_customer SET otp_code='$otp_code', otp_expires_at='$otp_expires_at' WHERE email='$email'";
    mysqli_query($conn, $update_sql);
    
    $sql = "SELECT full_name FROM tbl_customer WHERE email='$email'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $full_name = $row['full_name'];
        
        require_once '../config/mailer.php';
        $subject = "MedBD - New Verification Code";
        $body = "
            <h3>Hi $full_name,</h3>
            <p>Your new email verification code is: <b style='font-size:24px; color:#155e58;'>$otp_code</b></p>
            <p>This code will expire in 15 minutes.</p>
        ";
        sendMail($email, $full_name, $subject, $body);
        
        $_SESSION['verify-msg'] = "<div class='auth-message success'>A new verification code has been sent to your email.</div>";
    }
}
header('location:' . SITEURL . 'customer/verify-otp.php');
exit();
?>
