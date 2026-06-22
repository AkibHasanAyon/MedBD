<?php include('partials-front/menu.php'); ?>

<!-- product sEARCH Section Starts Here -->
<section class="product-search text-center">
    <div class="container">
        <?php
           
           
               //get the search keyword
               $search=mysqli_real_escape_string($conn, $_POST['search']);
           
           
           ?>

        <h2>Product on Your Search <a href="#" class="text-white">"<?php echo htmlspecialchars($search); ?>"</a></h2>

    </div>
</section>
<!-- product sEARCH Section Ends Here -->



<!-- product MEnu Section Starts Here -->
<section class="product-menu">
    <div class="container">
        <h2 class="text-center">Product Menu</h2>

        <?php


               //SQL QUERY to get product based on search key word
               $sql="SELECT * FROM tbl_product WHERE title LIKE  '%$search%' OR description LIKE '%$search%' ";

               //Execute the Query 
               $res=mysqli_query($conn, $sql);
               //Count Rows
               $count=mysqli_num_rows($res);

               //check whether product available or not
               if($count>0)
               {
                 //product AVailable 
                 while($row=mysqli_fetch_assoc($res)) 
                 {
                     //get the values
                     $id=$row['id'];
                     $title=$row['title']; 
                     $price=$row['price'];
                     $description=$row['description'];
                     $image_name=$row['image_name'];  
                     ?>

        <div class="product-menu-box">
            <div class="product-menu-img">
                <?php
                     //check whether image is available or not
                     if($image_name=="")
                     {
                         //Image Not Available
                         echo "<div class='error'>Image Not Available.</div>";
                     }
                     else
                     {
                          //image Available
                        ?>
                <img src="<?php echo SITEURL;?>images/product/<?php echo $image_name;?>" alt="  medicine "
                    class="img-responsive img-curve">
                <?php
                      }
                    ?>

            </div>

            <div class="product-menu-desc">
                <a href="<?php echo SITEURL; ?>product-detail.php?id=<?php echo $id; ?>" style="text-decoration:none;">
                    <h4 style="color:#155e58;"><?php echo $title;?></h4>
                </a>
                
                <?php
                    // Get average rating
                    $rate_sql = "SELECT AVG(rating) as avg_rate FROM tbl_review WHERE product_id=$id";
                    $rate_res = mysqli_query($conn, $rate_sql);
                    $rate_row = mysqli_fetch_assoc($rate_res);
                    $avg_rate = $rate_row['avg_rate'] ? round($rate_row['avg_rate'], 1) : 0;
                ?>
                <div style="color: #ffb300; font-size: 14px; margin-bottom: 5px;">
                    <?php 
                        for($i=1; $i<=5; $i++) {
                            if ($i <= round($avg_rate)) echo "★";
                            else echo "☆";
                        }
                    ?>
                    <span style="color:#888; font-size:12px;">(<?php echo $avg_rate; ?>)</span>
                </div>

                <p class="product-price">৳ <?php echo $price;?></p>
                <p class="product-detail">
                    <?php echo $description;?>
                </p>
                <br>

                <a href="<?php echo SITEURL; ?>add-to-cart.php?product_id=<?php echo $id; ?>" class="btn btn-primary" style="background:#155e58; border:none; margin-right:5px;">Add to Cart</a>
                <a href="<?php echo SITEURL; ?>order.php?product_id=<?php echo $id; ?>" class="btn btn-primary">Buy Now</a>
            </div>
        </div>

        <?php

                 }


               }
               else{
                    //product Not AVailable  
                    echo"<div class='error'>product Not Found</div>";
               }



            ?>




        <div class="clearfix"></div>



    </div>

</section>
<!-- product Menu Section Ends Here -->
<?php include('partials-front/footer.php'); ?>