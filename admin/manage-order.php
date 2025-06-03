<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">

        <h1>Manage Order</h1>

        <br> <br> <br>
        <?php

           if(isset($_SESSION['update']))
           {
          
            
              echo $_SESSION['update'];//Displaying session message
              unset($_SESSION['update']);//removing session message
            
           }

        ?>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php
               //Get all the orders from database

               $sql="SELECT * FROM tbl_order ORDER BY id DESC";

               //Execute the query
               $res=mysqli_query($conn, $sql);
               //Count the rows
               $count=mysqli_num_rows($res);

               $sn= 1;//Create a Serial Number and set the value to 1
             
                   
               if($count>0)
               {
                 //order Available
                 while($row=mysqli_fetch_assoc($res))
                 {
                   //get All the order details
                   $id=$row['id'];
                   $product=$row['product'];
                   $price=$row['price'];
                   $qty=$row['qty'];
                   $total=$row['total'];
                   $order_date=$row['order_date'];
                   $status=$row['status'];
                   $customer_name=$row['customer_name'];
                   $customer_contact=$row['customer_contact'];
                   $customer_email=$row['customer_email'];
                   $customer_address=$row['customer_address'];
                   

                   ?>

            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $product; ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo $qty; ?></td>
                <td><?php echo $total; ?></td>
                <td><?php echo $order_date; ?></td>

                <td>
                    <?php
                         //Ordered On delivery,delivered,cancelled
                         if($status=="Ordered")
                         {
                           echo "<label>$status</label>";
                         }
                         else if($status=="On Delivery")
                         {
                          echo "<label style='color:orange;'>$status</label>";
                         }
                         else if($status=="Delivered")
                         {
                          echo "<label style='color:green;'>$status</label>";
                         }
                         else if($status=="Cancelled")
                         {
                          echo "<label style='color:red;'>$status</label>";
                         }
                      ?>
                </td>
                <td><?php echo $customer_name; ?></td>
                <td><?php echo $customer_contact; ?></td>
                <td><?php echo $customer_email; ?></td>
                <td><?php echo $customer_address; ?></td>
                <td>
                    <a href="<?php echo SITEURL;?>admin/update-order.php?id=<?php echo $id; ?>"
                        class="btn-secondary">Update Order</a>
                </td>
            </tr>





            <?php


                 }
               }
               else
               {
                 //order Not Available
                 echo "<tr><td colspan='12' class='error'>Orders Not Available</td></tr>";
               }

           ?>





        </table>
        <!-- <div class="clearfix"></div> -->
    </div>
</div>


<?php include('partials/footer.php') ?>