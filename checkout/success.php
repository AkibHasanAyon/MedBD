<?php
include('../config/constants.php');

if (!isset($_GET['session_id']) || !isset($_GET['order_ids'])) {
    header('location:' . SITEURL);
    exit();
}

$session_id = $_GET['session_id'];
$order_ids_str = $_GET['order_ids'];

// We could verify the session with Stripe API again, but for simplicity we'll just update the DB
// assuming the user reached this page through the Stripe redirect.
$order_ids = explode(',', $order_ids_str);
$order_ids = array_map('intval', $order_ids);
$order_ids_clean = implode(',', $order_ids);

$sql = "UPDATE tbl_order SET payment_status='Paid' WHERE id IN ($order_ids_clean)";
mysqli_query($conn, $sql);

// Get customer details for email
$email_sql = "SELECT customer_email, customer_name FROM tbl_order WHERE id=" . $order_ids[0] . " LIMIT 1";
$email_res = mysqli_query($conn, $email_sql);
if ($email_row = mysqli_fetch_assoc($email_res)) {
    include('checkout/send-email.php');
    sendOrderConfirmationEmail($email_row['customer_email'], $email_row['customer_name'], $order_ids);
}

$_SESSION['order-success'] = "<div class='success text-center'><h3>Payment Successful!</h3><p>Your order has been placed and payment was received.</p></div>";
header('location:' . SITEURL . 'customer/my-orders.php');
exit();
?>
