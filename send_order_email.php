<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

function sendOrderConfirmationEmail($to_email, $customer_name, $order_ids) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        // User provided credentials
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('noreply@medbd.com', 'MedBD');
        $mail->addAddress($to_email, $customer_name);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmation - MedBD';
        $mail->Body    = "
            <h3>Dear $customer_name,</h3>
            <p>Thank you for your order!</p>
            <p>Your order has been placed successfully. Your order numbers are: <strong>" . implode(', ', $order_ids) . "</strong>.</p>
            <p>You can track your order status from your MedBD account dashboard.</p>
            <br>
            <p>Regards,<br>MedBD Team</p>
        ";
        $mail->AltBody = "Dear $customer_name,\n\nThank you for your order!\nYour order has been placed successfully. Your order numbers are: " . implode(', ', $order_ids) . ".\n\nRegards,\nMedBD Team";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log error silently
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
