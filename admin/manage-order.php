<?php include('partials/menu.php') ?>

    <div class="wrapper">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1 class="page-title" style="margin-bottom: 0;">Manage Orders</h1>
        </div>

        <?php
           if(isset($_SESSION['update'])) {
              echo $_SESSION['update'];
              unset($_SESSION['update']);
           }
        ?>

        <div class="table-container">
            <table class="tbl-full" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th width="3%">S.N.</th>
                        <th width="15%">Product</th>
                        <th width="5%">Price</th>
                        <th width="5%">Qty</th>
                        <th width="8%">Total</th>
                        <th width="10%">Order Date</th>
                        <th width="8%">Status</th>
                        <th width="10%">Payment</th>
                        <th width="8%">Prescription</th>
                        <th width="12%">Customer Name</th>
                        <th width="8%">Contact</th>
                        <th width="8%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                   $sql="SELECT * FROM tbl_order ORDER BY id DESC";
                   $res=mysqli_query($conn, $sql);
                   $count=mysqli_num_rows($res);
                   $sn= 1;
                 
                   if($count>0) {
                     while($row=mysqli_fetch_assoc($res)) {
                       $id=$row['id'];
                       $product=$row['product'];
                       $price=$row['price'];
                       $qty=$row['qty'];
                       $total=$row['total'];
                       $order_date=$row['order_date'];
                       $status=$row['status'];
                       $payment_method = $row['payment_method'];
                       $payment_status = $row['payment_status'];
                       $prescription_image = $row['prescription_image'];
                       $customer_name=$row['customer_name'];
                       $customer_contact=$row['customer_contact'];
                       
                       ?>
                        <tr>
                            <td><?php echo $sn++; ?>. </td>
                            <td style="font-weight: 500;"><?php echo $product; ?></td>
                            <td>৳<?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td style="font-weight: 600; color: var(--primary);">৳<?php echo $total; ?></td>
                            <td style="color: #666; font-size: 13px;"><?php echo date("M j, Y g:i A", strtotime($order_date)); ?></td>

                            <td>
                                <?php
                                     if($status=="Ordered") {
                                       echo "<span style='background:#f3f4f6; color:#4b5563; padding:2px 8px; border-radius:12px; font-weight:500;'>$status</span>";
                                     } else if($status=="On Delivery") {
                                       echo "<span style='background:#fef3c7; color:#d97706; padding:2px 8px; border-radius:12px; font-weight:500;'>$status</span>";
                                     } else if($status=="Delivered") {
                                       echo "<span style='background:#ecfdf5; color:#059669; padding:2px 8px; border-radius:12px; font-weight:500;'>$status</span>";
                                     } else if($status=="Cancelled") {
                                       echo "<span style='background:#fef2f2; color:#dc2626; padding:2px 8px; border-radius:12px; font-weight:500;'>$status</span>";
                                     }
                                  ?>
                            </td>

                            <td>
                                <?php echo $payment_method; ?><br>
                                <?php 
                                    if($payment_status == 'Paid') echo "<span style='color:#059669;font-size:12px;font-weight:500;'>(Paid)</span>";
                                    else echo "<span style='color:#dc2626;font-size:12px;font-weight:500;'>(Pending)</span>";
                                ?>
                            </td>

                            <td>
                                <?php if($prescription_image != ""): ?>
                                    <a href="<?php echo SITEURL; ?>images/prescription/<?php echo $prescription_image; ?>" target="_blank" style="color:var(--primary); text-decoration:none; display:flex; align-items:center; gap:4px; font-weight:500;"><i class='bx bx-file'></i> View</a>
                                <?php else: ?>
                                    <span style="color:#9ca3af; font-size:13px;">N/A</span>
                                <?php endif; ?>
                            </td>

                            <td style="font-size: 13px;">
                                <strong><?php echo $customer_name; ?></strong>
                            </td>
                            <td style="font-size: 13px; color:#555;"><?php echo $customer_contact; ?></td>
                            <td>
                                <a href="<?php echo SITEURL;?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary" style="font-size: 12px; padding: 4px 8px;"><i class='bx bx-edit'></i> Edit</a>
                            </td>
                        </tr>
                    <?php
                     }
                   } else {
                     echo "<tr><td colspan='12' style='text-align:center; padding:30px; color:#666;'>Orders Not Available</td></tr>";
                   }
               ?>
                </tbody>
            </table>
        </div>
    </div>


<?php include('partials/footer.php') ?>