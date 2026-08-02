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
            // Group products ordered in the same cart checkout (identical order_date)
            $grouped_orders = [];
            while ($order = mysqli_fetch_assoc($order_res)) {
                $group_key = $order['order_date']; 
                if (!isset($grouped_orders[$group_key])) {
                    $grouped_orders[$group_key] = [
                        'main_id' => $order['id'],
                        'date' => $order['order_date'],
                        'status' => $order['status'],
                        'payment_method' => $order['payment_method'],
                        'payment_status' => $order['payment_status'],
                        'total' => 0,
                        'items' => []
                    ];
                }
                $grouped_orders[$group_key]['total'] += $order['total'];
                $grouped_orders[$group_key]['items'][] = [
                    'product' => $order['product'],
                    'qty' => $order['qty'],
                    'price' => $order['price'],
                    'total' => $order['total']
                ];
            }
        ?>
            <table class="order-history-table">
                <tr>
                    <th>Order #</th>
                    <th>Products Ordered</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
                <?php foreach ($grouped_orders as $group): ?>
                    <tr>
                        <td>#<?php echo $group['main_id']; ?></td>
                        <td>
                            <?php foreach ($group['items'] as $item): ?>
                                <div style="padding: 4px 0; border-bottom: 1px solid #f0f0f0;">
                                    <strong style="color: #333;"><?php echo htmlspecialchars($item['product']); ?></strong> 
                                    <span style="color: #666; font-size: 13px;">(x<?php echo $item['qty']; ?> — ৳<?php echo $item['total']; ?>)</span>
                                </div>
                            <?php endforeach; ?>
                        </td>
                        <td><strong style="color: #155e58; font-size: 16px;">৳<?php echo $group['total']; ?></strong></td>
                        <td><?php echo date('d M Y, h:i A', strtotime($group['date'])); ?></td>
                        <td>
                            <?php
                            $status = $group['status'];
                            $status_class = 'status-ordered';
                            if ($status == 'On Delivery') $status_class = 'status-on-delivery';
                            elseif ($status == 'Delivered') $status_class = 'status-delivered';
                            elseif ($status == 'Cancelled') $status_class = 'status-cancelled';
                            ?>
                            <span class="status-badge <?php echo $status_class; ?>"><?php echo $status; ?></span>
                        </td>
                        <td>
                            <?php 
                                echo $group['payment_method']; 
                                if ($group['payment_status'] == 'Paid') {
                                    echo " <span style='color:green;font-size:12px;'>(Paid)</span>";
                                } else {
                                    echo " <span style='color:orange;font-size:12px;'>(Pending)</span>";
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
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
