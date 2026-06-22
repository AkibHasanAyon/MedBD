<?php include('partials-front/menu.php'); ?>

<?php
// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer-login-msg'] = "<div class='auth-message error'>Please login to view your cart.</div>";
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}
$customer_id = (int)$_SESSION['customer_id'];
?>

<section class="cart-section" style="padding: 40px 20px; max-width: 1000px; margin: 0 auto; min-height: 50vh;">
    <h2 style="color: #155e58; border-bottom: 2px solid #15c293; padding-bottom: 10px;">Your Shopping Cart</h2>

    <?php
    if (isset($_SESSION['cart-msg'])) {
        echo $_SESSION['cart-msg'];
        unset($_SESSION['cart-msg']);
    }
    ?>

    <?php
    $sql = "SELECT c.id as cart_id, c.qty, p.id as product_id, p.title, p.price, p.image_name 
            FROM tbl_cart c 
            JOIN tbl_product p ON c.product_id = p.id 
            WHERE c.customer_id = $customer_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        $grand_total = 0;
    ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
            <tr style="background: #f5f5f5; text-align: left; border-bottom: 2px solid #ddd;">
                <th style="padding: 15px;">Product</th>
                <th style="padding: 15px;">Price</th>
                <th style="padding: 15px;">Quantity</th>
                <th style="padding: 15px;">Total</th>
                <th style="padding: 15px;">Action</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($res)) {
                $cart_id = $row['cart_id'];
                $title = $row['title'];
                $price = $row['price'];
                $qty = $row['qty'];
                $image_name = $row['image_name'];
                $total = $price * $qty;
                $grand_total += $total;
            ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px; display: flex; align-items: center; gap: 15px;">
                        <?php if ($image_name != ""): ?>
                            <img src="<?php echo SITEURL; ?>images/product/<?php echo $image_name; ?>" width="60px" style="border-radius: 4px;">
                        <?php else: ?>
                            <div style="width: 60px; height: 60px; background: #eee; display: flex; align-items: center; justify-content: center; border-radius: 4px; color: #888;">No Img</div>
                        <?php endif; ?>
                        <span style="font-weight: 600; color: #333;"><?php echo $title; ?></span>
                    </td>
                    <td style="padding: 15px; color: #555;">৳<?php echo $price; ?></td>
                    <td style="padding: 15px;">
                        <form action="<?php echo SITEURL; ?>update-cart.php" method="POST" style="display: flex; gap: 10px;">
                            <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                            <input type="number" name="qty" value="<?php echo $qty; ?>" min="1" style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                            <input type="submit" name="update" value="Update" style="padding: 5px 10px; background: #155e58; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        </form>
                    </td>
                    <td style="padding: 15px; font-weight: bold; color: #155e58;">৳<?php echo $total; ?></td>
                    <td style="padding: 15px;">
                        <a href="<?php echo SITEURL; ?>remove-from-cart.php?id=<?php echo $cart_id; ?>" style="color: #e74c3c; text-decoration: none; font-weight: bold;">Remove</a>
                    </td>
                </tr>
            <?php } ?>
            
            <tr style="background: #f9f9f9;">
                <td colspan="3" style="padding: 20px; text-align: right; font-weight: bold; font-size: 18px;">Grand Total:</td>
                <td colspan="2" style="padding: 20px; font-weight: bold; font-size: 18px; color: #e65100;">৳<?php echo $grand_total; ?></td>
            </tr>
        </table>

        <div style="margin-top: 30px; text-align: right; display: flex; justify-content: space-between; align-items: center;">
            <a href="<?php echo SITEURL; ?>product.php" style="color: #155e58; text-decoration: none; font-weight: 600;">← Continue Shopping</a>
            <a href="<?php echo SITEURL; ?>order.php?cart=1" style="padding: 15px 30px; background: linear-gradient(135deg, #155e58, #15c293); color: white; text-decoration: none; border-radius: 8px; font-size: 18px; font-weight: bold; display: inline-block; box-shadow: 0 4px 10px rgba(21,194,147,0.3);">Proceed to Checkout</a>
        </div>

    <?php
    } else {
        echo "<div style='text-align: center; padding: 50px 0;'>";
        echo "<img src='images/cart-empty.png' alt='Empty Cart' style='width: 150px; opacity: 0.5; margin-bottom: 20px;'>";
        echo "<h3 style='color: #777;'>Your cart is empty</h3>";
        echo "<br><a href='" . SITEURL . "product.php' class='btn btn-primary'>Browse Products</a>";
        echo "</div>";
    }
    ?>
</section>

<?php include('partials-front/footer.php'); ?>
