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
$success_url = SITEURL . 'checkout/success.php?session_id={CHECKOUT_SESSION_ID}&order_ids=' . urlencode($order_ids_str);
$cancel_url = SITEURL . 'customer/my-orders.php?payment=failed';

$ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $stripe_secret_key . ':');
$post_fields = [
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
];

if (isset($_SESSION['customer_email'])) {
    $post_fields['customer_email'] = $_SESSION['customer_email'];
}

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));

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
    // Error creating checkout session - Clean up pending order from DB so user isn't stuck with unpayable orders!
    $ids = explode(',', $order_ids_str);
    $clean_ids = [];
    foreach ($ids as $id) {
        $clean_id = (int) trim($id);
        if ($clean_id > 0) {
            $clean_ids[] = $clean_id;
        }
    }
    if (!empty($clean_ids)) {
        $id_list = implode(',', $clean_ids);
        // Revert stock quantity and remove orders
        $res_ord = mysqli_query($conn, "SELECT product_id, qty FROM tbl_order WHERE id IN ($id_list)");
        while ($o = mysqli_fetch_assoc($res_ord)) {
            $pid = (int) $o['product_id'];
            $pqty = (int) $o['qty'];
            mysqli_query($conn, "UPDATE tbl_product SET stock_qty = stock_qty + $pqty WHERE id = $pid");
        }
        mysqli_query($conn, "DELETE FROM tbl_order WHERE id IN ($id_list)");
    }

    $error_msg = isset($session['error']['message']) ? $session['error']['message'] : 'Unknown error';
    $_SESSION['order-error'] = "<div class='error text-center' style='background:#fef2f2; border:1px solid #f87171; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:15px;'><h3>Payment Setup Failed</h3><p>Could not initialize online card payment: " . htmlspecialchars($error_msg) . "</p></div>";
    header('location:' . SITEURL . 'cart/');
    exit();
}
?>
