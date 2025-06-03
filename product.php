<?php include('partials-front/menu.php'); ?>

<!-- product sEARCH Section Starts Here -->
<section class="product-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL;?>product-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for product.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- product sEARCH Section Ends Here -->



<!-- product MEnu Section Starts Here -->
<section class="product-menu">
    <div class="container">
        <h2 class="text-center">Product Menu</h2>


        <?php
             //Display product that are Active
             $sql="SELECT * FROM tbl_product WHERE active='Yes'  ";


             //Execute the query
            $res=mysqli_query($conn, $sql);

            //count rows 
             $count=mysqli_num_rows($res);
             if($count>0)
             {
              //product Available
                 while($row=mysqli_fetch_assoc($res))
                 {
                     //get all the values

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
                <h4><?php echo $title;?></h4>
                <p class="product-price">৳ <?php echo $price;?></p>
                <p class="product-detail">
                    <?php echo $description;?>
                </p>
                <br>

                <a href="<?php echo SITEURL; ?>order.php?product_id=<?php echo $id; ?>" class="btn btn-primary">Order
                    Now</a>
            </div>
        </div>


        <?php 
                 }

              }
              else
              {
                //product Not Available
                echo "<div class='error'>Product Not Available.</div>";
              }

         ?>



        <div class="clearfix"></div>



    </div>

</section>
<!-- product Menu Section Ends Here -->
<?php include('partials-front/footer.php'); ?>