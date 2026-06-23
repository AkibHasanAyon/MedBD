<?php include('../partials-front/menu.php'); ?>

<?php
// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer-login-msg'] = "Please login to proceed with checkout.";
    // If it's a cart checkout, just redirect back to order.php?cart=1. Otherwise back to the product.
    $redirect_url = isset($_GET['cart']) ? 'order.php?cart=1' : (isset($_GET['product_id']) ? 'order.php?product_id=' . (int)$_GET['product_id'] : 'cart.php');
    header('location:' . SITEURL . 'customer/login.php?redirect=' . urlencode($redirect_url));
    exit();
}

$customer_id = (int)$_SESSION['customer_id'];

// Get customer details for pre-filling the form
$cust_sql = "SELECT * FROM tbl_customer WHERE id=$customer_id";
$cust_res = mysqli_query($conn, $cust_sql);
$customer = mysqli_fetch_assoc($cust_res);

// Determine if single product checkout or cart checkout
$items = [];
$total_amount = 0;
$requires_prescription = false;
$is_cart = false;

if (isset($_GET['product_id'])) {
    // Single product "Buy Now"
    $product_id = (int)$_GET['product_id'];
    $sql = "SELECT * FROM tbl_product WHERE id=$product_id AND active='Yes'";
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) == 1) {
        $product = mysqli_fetch_assoc($res);
        $product['qty'] = 1;
        $items[] = $product;
        $total_amount = $product['price'];
        if ($product['requires_prescription'] == 'Yes') {
            $requires_prescription = true;
        }
    } else {
        header('location:' . SITEURL);
        exit();
    }
} elseif (isset($_GET['cart']) && $_GET['cart'] == 1) {
    // Cart checkout
    $is_cart = true;
    $sql = "SELECT c.qty, p.* FROM tbl_cart c JOIN tbl_product p ON c.product_id = p.id WHERE c.customer_id=$customer_id";
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $items[] = $row;
            $total_amount += ($row['price'] * $row['qty']);
            if ($row['requires_prescription'] == 'Yes') {
                $requires_prescription = true;
            }
        }
    } else {
        header('location:' . SITEURL . 'cart/');
        exit();
    }
} else {
    header('location:' . SITEURL);
    exit();
}

// Ensure total_amount is an integer for Stripe (in cents)
$total_amount_cents = round($total_amount * 100);
?>
<link rel="stylesheet" href="<?php echo SITEURL; ?>css/checkout.css">

<section class="checkout-section" style="padding: 50px 20px; min-height: 70vh;">
    <div class="container" style="max-width: 1050px; margin: 0 auto;">
        
        <div style="display: flex; align-items: center; margin-bottom: 40px;">
            <i class='bx bx-check-shield' style="font-size: 32px; color: #155e58; margin-right: 15px;"></i>
            <h2 style="color: #155e58; margin: 0; font-size: 32px; font-weight: 700;">Secure Checkout</h2>
        </div>

        <?php
        if (isset($_SESSION['order-error'])) {
            echo $_SESSION['order-error'];
            unset($_SESSION['order-error']);
        }
        ?>

        <div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 40px;">
            
            <!-- Left Column: Delivery Details -->
            <div style="background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                <h3 style="color: #222; margin-bottom: 25px; font-size: 22px; font-weight: 700; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;">Delivery Details</h3>
                
                <form action="checkout/process.php" method="POST" enctype="multipart/form-data" id="checkout-form">
                    
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="customer_name" class="form-control" value="<?php echo htmlspecialchars($customer['full_name']); ?>" required placeholder="John Doe">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="customer_contact" class="form-control" value="<?php echo htmlspecialchars($customer['phone']); ?>" required placeholder="+880 1XXXXXXXXX">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="customer_email" class="form-control" value="<?php echo htmlspecialchars($customer['email']); ?>" required placeholder="john@example.com">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 30px;">
                        <label class="form-label">Complete Address</label>
                        <textarea name="customer_address" class="form-control" required rows="3" placeholder="House/Flat No, Street, Area, City"><?php echo htmlspecialchars($customer['address']); ?></textarea>
                    </div>

                    <?php if ($requires_prescription): ?>
                    <div class="prescription-box">
                        <h4 style="color: #c62828; margin-top: 0; display: flex; align-items: center; gap: 8px;">
                            <i class='bx bx-error-circle'></i> Prescription Required
                        </h4>
                        <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 15px;">You have items in your cart that require a valid doctor's prescription. Please upload a clear image of it.</p>
                        <input type="file" name="prescription" accept="image/*" required style="width: 100%; padding: 12px; background: #fff; border: 1px dashed #d32f2f; border-radius: 8px; cursor: pointer;">
                    </div>
                    <?php endif; ?>

                    <h3 style="color: #222; margin-top: 40px; margin-bottom: 25px; font-size: 22px; font-weight: 700; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;">Payment Method</h3>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="Cash on Delivery" checked>
                        <span class="payment-text">Cash on Delivery (COD)</span>
                        <i class='bx bx-money'></i>
                    </label>
                    
                    <label class="payment-option" style="margin-bottom: 35px;">
                        <input type="radio" name="payment_method" value="Stripe">
                        <span class="payment-text">Pay Online with Card (Stripe)</span>
                        <i class='bx bxl-stripe' style="color: #6772e5;"></i>
                    </label>

                    <!-- Hidden fields -->
                    <input type="hidden" name="is_cart" value="<?php echo $is_cart ? '1' : '0'; ?>">
                    <?php if (!$is_cart): ?>
                        <input type="hidden" name="product_id" value="<?php echo $items[0]['id']; ?>">
                    <?php endif; ?>

                    <button type="submit" name="submit" class="btn-confirm">
                        Place Order <i class='bx bx-right-arrow-alt' style="vertical-align: middle; margin-left: 5px;"></i>
                    </button>
                </form>
            </div>

            <!-- Right Column: Order Summary -->
            <div>
                <div style="background: #fff; padding: 35px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); position: sticky; top: 30px;">
                    <h3 style="color: #222; margin-bottom: 25px; font-size: 20px; font-weight: 700;">Order Summary</h3>
                    
                    <div style="max-height: 350px; overflow-y: auto; padding-right: 15px; margin-bottom: 25px;">
                        <?php foreach ($items as $item): ?>
                        <div class="summary-item">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <?php if ($item['image_name']): ?>
                                    <img src="<?php echo SITEURL; ?>images/product/<?php echo $item['image_name']; ?>" style="width: 55px; height: 55px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                                <?php else: ?>
                                    <div style="width: 55px; height: 55px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i class='bx bx-image' style="color: #ccc; font-size: 24px;"></i></div>
                                <?php endif; ?>
                                <div>
                                    <p style="margin: 0 0 4px 0; font-weight: 600; font-size: 15px; color: #333; line-height: 1.3;"><?php echo htmlspecialchars($item['title']); ?></p>
                                    <p style="margin: 0; color: #777; font-size: 13px; background: #f5f5f5; display: inline-block; padding: 2px 8px; border-radius: 12px;">Qty: <?php echo $item['qty']; ?></p>
                                </div>
                            </div>
                            <div style="font-weight: 700; color: #155e58; font-size: 15px;">
                                ৳<?php echo number_format($item['price'] * $item['qty'], 2); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div style="background: #fdfdfd; padding: 20px; border-radius: 12px; border: 1px dashed #dce1e6;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span style="color: #666; font-size: 15px;">Subtotal</span>
                            <span style="font-weight: 600; color: #333;">৳<?php echo number_format($total_amount, 2); ?></span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eaeaea;">
                            <span style="color: #666; font-size: 15px;">Shipping</span>
                            <span style="font-weight: 600; color: #2e7d32; background: #e8f5e9; padding: 2px 8px; border-radius: 4px; font-size: 14px;">Free</span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 700; font-size: 18px; color: #222;">Total Amount</span>
                            <span style="font-weight: 800; font-size: 28px; color: #e65100;">৳<?php echo number_format($total_amount, 2); ?></span>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</section>

<?php include('../partials-front/footer.php'); ?>