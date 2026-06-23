<?php
include('../config/constants.php');

if (!isset($_SESSION['customer_id']) || !isset($_GET['order_ids']) || !isset($_GET['amount'])) {
    header('location:' . SITEURL);
    exit();
}

$order_ids_str = $_GET['order_ids'];
$amount_cents = (int)$_GET['amount'];

// Simple Stripe API integration using cURL (no external libraries needed)
$stripe_secret_key = STRIPE_SECRET_KEY;
$success_url = SITEURL . 'stripe-success.php?session_id={CHECKOUT_SESSION_ID}&order_ids=' . urlencode($order_ids_str);
$cancel_url = SITEURL . 'customer/my-orders.php?payment=failed';

$ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $stripe_secret_key . ':');
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'payment_method_types' => ['card'],
    'line_items' => [
        [
            'price_data' => [
                'currency' => 'bdt',
                'product_data' => [
                    'name' => 'MedBD Order (' . $order_ids_str . ')',
                ],
                'unit_amount' => $amount_cents,
            ],
            'quantity' => 1,
        ]
    ],
    'mode' => 'payment',
    'success_url' => $success_url,
    'cancel_url' => $cancel_url,
]));

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$session = json_decode($response, true);

if ($http_code == 200 && isset($session['id'])) {
    // Redirect to Stripe Checkout
    header("HTTP/1.1 303 See Other");
    header("Location: " . $session['url']);
    exit();
} else {
    // Error creating checkout session
    $error_msg = isset($session['error']['message']) ? $session['error']['message'] : 'Unknown error';
    $_SESSION['order-success'] = "<div class='error text-center'><h3>Payment Setup Failed</h3><p>Could not connect to payment gateway: " . htmlspecialchars($error_msg) . "</p></div>";
    header('location:' . SITEURL . 'customer/my-orders.php');
    exit();
}
?>
