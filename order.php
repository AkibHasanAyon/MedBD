<?php include('partials-front/menu.php'); ?>

<?php
// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer-login-msg'] = "<div class='auth-message error'>Please login to proceed with checkout.</div>";
    header('location:' . SITEURL . 'customer/login.php');
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
        header('location:' . SITEURL . 'cart.php');
        exit();
    }
} else {
    header('location:' . SITEURL);
    exit();
}

// Ensure total_amount is an integer for Stripe (in cents)
$total_amount_cents = round($total_amount * 100);
?>

<section class="checkout-section" style="padding: 40px 20px; background: #f9f9f9; min-height: 70vh;">
    <div class="container" style="max-width: 1000px; margin: 0 auto;">
        <h2 style="color: #155e58; border-bottom: 2px solid #15c293; padding-bottom: 10px; margin-bottom: 30px;">Checkout</h2>

        <?php
        if (isset($_SESSION['order-error'])) {
            echo $_SESSION['order-error'];
            unset($_SESSION['order-error']);
        }
        ?>

        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px;">
            
            <!-- Left Column: Delivery Details -->
            <div style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: #333; margin-bottom: 20px;">Delivery Information</h3>
                
                <form action="process-order.php" method="POST" enctype="multipart/form-data" id="checkout-form">
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Full Name</label>
                        <input type="text" name="customer_name" value="<?php echo htmlspecialchars($customer['full_name']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Phone Number</label>
                        <input type="tel" name="customer_contact" value="<?php echo htmlspecialchars($customer['phone']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Email Address</label>
                        <input type="email" name="customer_email" value="<?php echo htmlspecialchars($customer['email']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Delivery Address</label>
                        <textarea name="customer_address" required rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"><?php echo htmlspecialchars($customer['address']); ?></textarea>
                    </div>

                    <?php if ($requires_prescription): ?>
                    <div style="margin-bottom: 25px; padding: 15px; background: #ffebee; border-left: 4px solid #f44336; border-radius: 4px;">
                        <h4 style="color: #c62828; margin-top: 0;">Prescription Required</h4>
                        <p style="font-size: 14px; color: #555; margin-bottom: 10px;">One or more items in your order require a doctor's prescription. Please upload an image of your prescription below.</p>
                        <input type="file" name="prescription" accept="image/*" required style="width: 100%; padding: 10px; background: #fff; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    <?php endif; ?>

                    <h3 style="color: #333; margin-top: 30px; margin-bottom: 20px;">Payment Method</h3>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: flex; align-items: center; padding: 15px; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; background: #fdfdfd;">
                            <input type="radio" name="payment_method" value="Cash on Delivery" checked style="margin-right: 10px; width: 18px; height: 18px;">
                            <span style="font-weight: 600;">Cash on Delivery (COD)</span>
                        </label>
                    </div>
                    
                    <div style="margin-bottom: 25px;">
                        <label style="display: flex; align-items: center; padding: 15px; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; background: #fdfdfd;">
                            <input type="radio" name="payment_method" value="Stripe" style="margin-right: 10px; width: 18px; height: 18px;">
                            <span style="font-weight: 600;">Pay Online with Card (Stripe)</span>
                        </label>
                    </div>

                    <!-- Hidden fields to pass data to process-order.php -->
                    <input type="hidden" name="is_cart" value="<?php echo $is_cart ? '1' : '0'; ?>">
                    <?php if (!$is_cart): ?>
                        <input type="hidden" name="product_id" value="<?php echo $items[0]['id']; ?>">
                    <?php endif; ?>

                    <input type="submit" name="submit" value="Confirm Order" style="width: 100%; padding: 15px; background: linear-gradient(135deg, #155e58, #15c293); color: white; border: none; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 10px rgba(21,194,147,0.3);">
                </form>
            </div>

            <!-- Right Column: Order Summary -->
            <div>
                <div style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: sticky; top: 20px;">
                    <h3 style="color: #333; margin-bottom: 20px;">Order Summary</h3>
                    
                    <div style="max-height: 300px; overflow-y: auto; padding-right: 10px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        <?php foreach ($items as $item): ?>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <?php if ($item['image_name']): ?>
                                    <img src="<?php echo SITEURL; ?>images/product/<?php echo $item['image_name']; ?>" style="width: 50px; border-radius: 4px;">
                                <?php else: ?>
                                    <div style="width: 50px; height: 50px; background: #eee; border-radius: 4px;"></div>
                                <?php endif; ?>
                                <div>
                                    <p style="margin: 0; font-weight: 600; font-size: 14px;"><?php echo htmlspecialchars($item['title']); ?></p>
                                    <p style="margin: 0; color: #888; font-size: 13px;">Qty: <?php echo $item['qty']; ?></p>
                                </div>
                            </div>
                            <div style="font-weight: bold; color: #155e58;">
                                ৳<?php echo ($item['price'] * $item['qty']); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: #666;">Subtotal</span>
                        <span style="font-weight: 600;">৳<?php echo $total_amount; ?></span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                        <span style="color: #666;">Shipping</span>
                        <span style="font-weight: 600; color: #2e7d32;">Free</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: bold; font-size: 18px; color: #333;">Total</span>
                        <span style="font-weight: bold; font-size: 24px; color: #e65100;">৳<?php echo $total_amount; ?></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>