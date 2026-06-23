<?php
require_once __DIR__ . '/../config/mailer.php';

function sendOrderConfirmationEmail($to_email, $customer_name, $order_ids) {
    $subject = 'Order Confirmation - MedBD';
    $body = "
        <h3>Dear $customer_name,</h3>
        <p>Thank you for your order!</p>
        <p>Your order has been placed successfully. Your order numbers are: <strong>" . implode(', ', $order_ids) . "</strong>.</p>
        <p>You can track your order status from your MedBD account dashboard.</p>
        <br>
        <p>Regards,<br>MedBD Team</p>
    ";
    $altBody = "Dear $customer_name,\n\nThank you for your order!\nYour order has been placed successfully. Your order numbers are: " . implode(', ', $order_ids) . ".\n\nRegards,\nMedBD Team";

    return sendMail($to_email, $customer_name, $subject, $body, $altBody);
}
?>
