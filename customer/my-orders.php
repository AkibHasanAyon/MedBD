<?php include('../partials-front/menu.php'); ?>
<?php include('login-check.php'); ?>

<?php
$customer_id = (int)$_SESSION['customer_id'];
?>

<section class="profile-section">
    <h2><i class='bx bx-list-ul'></i> My Orders</h2>

    <?php
    if (isset($_SESSION['order-success'])) {
        echo $_SESSION['order-success'];
        unset($_SESSION['order-success']);
    }
    ?>

    <div class="profile-card">
        <?php
        $order_sql = "SELECT * FROM tbl_order WHERE customer_id=$customer_id ORDER BY order_date DESC";
        $order_res = mysqli_query($conn, $order_sql);
        $order_count = mysqli_num_rows($order_res);

        if ($order_count > 0) {
        ?>
            <table class="order-history-table">
                <tr>
                    <th>Order #</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
                <?php while ($order = mysqli_fetch_assoc($order_res)): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['product']); ?></td>
                        <td><?php echo $order['qty']; ?></td>
                        <td>৳<?php echo $order['total']; ?></td>
                        <td><?php echo date('d M Y, h:i A', strtotime($order['order_date'])); ?></td>
                        <td>
                            <?php
                            $status = $order['status'];
                            $status_class = 'status-ordered';
                            if ($status == 'On Delivery') $status_class = 'status-on-delivery';
                            elseif ($status == 'Delivered') $status_class = 'status-delivered';
                            elseif ($status == 'Cancelled') $status_class = 'status-cancelled';
                            ?>
                            <span class="status-badge <?php echo $status_class; ?>"><?php echo $status; ?></span>
                        </td>
                        <td>
                            <?php 
                                echo $order['payment_method']; 
                                if ($order['payment_status'] == 'Paid') {
                                    echo " <span style='color:green;font-size:12px;'>(Paid)</span>";
                                } else {
                                    echo " <span style='color:orange;font-size:12px;'>(Pending)</span>";
                                }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php
        } else {
            echo "<p style='color:#888; text-align:center; padding:40px;'>You haven't placed any orders yet.</p>";
            echo "<div style='text-align:center;'><a href='" . SITEURL . "product.php' class='btn-auth' style='display:inline-block; width:auto; padding:10px 20px;'>Browse Products</a></div>";
        }
        ?>
    </div>
</section>

<?php include('../partials-front/footer.php'); ?>
