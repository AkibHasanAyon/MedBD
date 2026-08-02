<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php
           //Check whether id is set or not
           if(isset($_GET['id']))
           {
               $id=(int)$_GET['id'];
               $sql="SELECT * FROM tbl_order WHERE id=$id";
               $res=mysqli_query($conn, $sql);
               $count=mysqli_num_rows($res);
               if($count==1)
               {
                   $row=mysqli_fetch_assoc($res);
                   $status=$row['status'];
                   $customer_name=$row['customer_name'];
                   $customer_contact=$row['customer_contact'];
                   $customer_email=$row['customer_email'];
                   $customer_address=$row['customer_address'];
                   $order_date=$row['order_date'];
                   
                   // Fetch all products included in this exact checkout group
                   $items_sql="SELECT * FROM tbl_order WHERE order_date='$order_date' AND customer_email='$customer_email'";
                   $items_res=mysqli_query($conn, $items_sql);
                   $order_items=[];
                   $total_group_price=0;
                   while($item = mysqli_fetch_assoc($items_res)) {
                       $order_items[] = $item;
                       $total_group_price += $item['total'];
                   }
               }
               else
               {
                   header('location:'.SITEURL.'admin/manage-order.php');
                   exit();
               }
           }
           else
           {
               header('location:'.SITEURL.'admin/manage-order.php');
               exit();
           }
        ?>

        <form action="" method="POST">
            <table class="tbl_30" style="width: 50%;">
                <tr>
                    <td style="vertical-align: top; padding-top: 10px;">Ordered Products:</td>
                    <td>
                        <?php foreach($order_items as $itm): ?>
                            <div style="padding: 6px 0; border-bottom: 1px solid #eee;">
                                <strong style="color: #333;"><?php echo htmlspecialchars($itm['product']); ?></strong> 
                                <span style="color: #666; font-size: 13px;">(x<?php echo $itm['qty']; ?> — ৳<?php echo $itm['total']; ?>)</span>
                            </div>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <td>Total Order Amount:</td>
                    <td>
                        <b style="color: var(--primary); font-size: 16px;">৳<?php echo $total_group_price; ?></b>
                    </td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="status" style="padding: 6px 12px; border-radius: 4px; border: 1px solid #ccc; width: 100%;">
                            <option <?php if(trim($status)=="Ordered"){echo "selected ";} ?> value="Ordered">Ordered</option>
                            <option <?php if(trim($status)=="On Delivery"){echo "selected ";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if(trim($status)=="Delivered"){echo "selected ";} ?> value="Delivered">Delivered</option>
                            <option <?php if(trim($status)=="Cancelled"){echo "selected ";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>" style="width: 100%; padding: 6px;">
                    </td>
                </tr>
                <tr>
                    <td>Customer Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo htmlspecialchars($customer_contact); ?>" style="width: 100%; padding: 6px;">
                    </td>
                </tr>
                <tr>
                    <td>Customer Email:</td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo htmlspecialchars($customer_email); ?>" style="width: 100%; padding: 6px;">
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 10px;">Customer Address:</td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="4" style="width: 100%; padding: 6px;"><?php echo htmlspecialchars($customer_address); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 20px;">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="order_date" value="<?php echo $order_date; ?>">
                        <input type="hidden" name="orig_email" value="<?php echo $customer_email; ?>">
                        <input type="submit" name="submit" value="Update Order Status & Info" class="btn-secondary" style="padding: 10px 20px; cursor: pointer;">
                    </td>
                </tr>
            </table>
        </form>
        <?php
           
         if(isset($_POST['submit']))
         {
               $id = (int)$_POST['id'];
               $order_date = mysqli_real_escape_string($conn, $_POST['order_date']);
               $orig_email = mysqli_real_escape_string($conn, $_POST['orig_email']);
               $status = mysqli_real_escape_string($conn, $_POST['status']);
               $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
               $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
               $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
               $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);

             // Update status and customer info for all products in this checkout group
             $sql2="UPDATE tbl_order SET 
                   status='$status',
                   customer_name='$customer_name',
                   customer_contact='$customer_contact',
                   customer_email='$customer_email',
                   customer_address='$customer_address'
                   WHERE order_date='$order_date' AND customer_email='$orig_email'
             ";

             $res2 = mysqli_query($conn, $sql2);

             if($res2 == true)
             {
                 $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                 header('location:'.SITEURL.'admin/manage-order.php');
                 exit();
             }
             else
             {
                 $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                 header('location:'.SITEURL.'admin/manage-order.php');
                 exit();
             }
         }
         ?>


    </div>
</div>

<?php include("partials/footer.php") ?>