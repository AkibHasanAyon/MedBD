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
<?php
    if(isset($_SESSION['order']))
    {
        echo ($_SESSION['order']);
        unset($_SESSION['order']);
    }
   ?>
<!-- features -->
<section id="feature" class="section-p1">
    <div class="fe-box">
        <img src="images/features/f1.png" alt="">
        <h6>Free Shipping</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f2.png" alt="">
        <h6>Online Order</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f3.png" alt="">
        <h6>Save Money</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f4.png" alt="">
        <h6>Promotions</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f5.png" alt="">
        <h6>Happy Sell</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f6.png" alt="">
        <h6>24/7 Support</h6>
    </div>
</section>
<!-- features -->

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center color-primary">Featured</h2>

        <?php 
            //Create SQL query to display categories from database

            $sql="SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes'
            ";
            //Execute the query
            $res=mysqli_query($conn, $sql);
           //count rows to check whether the category is available or not
           $count=mysqli_num_rows($res);

           if($count>0)
           {
               //Categories available
               while($row=mysqli_fetch_assoc($res))
               {
                   //Get the Values like id,title,image_name
                   $id=$row['id'];
                   $title=$row['title'];
                   $image_name=$row['image_name'];
                   ?>

        <a href="<?php echo SITEURL;?>category-product.php?category_id=<?php echo $id ?> ">
            <div class="box-3 float-container">
                <?php 
                        //check wheether image is available or not
                         if($image_name=="")
                         {
                             //display message
                             echo "<div class=error>Image Not Available.</div>";
                         }
                         else
                         {
                             //image Available
                             ?>
                <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt=""
                    class="img-responsive img-curve-cat">
                <?php
                         }


                        ?>


                <p class="float-text b-text"><?php echo $title; ?></p>
            </div>
        </a>

        <?php
               }

           }
           else
           {
             //Categories not available
             echo "<div class=error>Category Not available.</div>";
           }            
            ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- product MEnu Section Starts Here -->
<section class="product-menu">
    <div class="container">
        <h2 class="text-center color-primary">Our Exclusive Products</h2>
        <?php 
            
            //Getting product from database that are active and featured
            //SQL query

              $sql2="SELECT * FROM tbl_product WHERE active='Yes' AND featured='Yes' LIMIT 6";
            
              //Execute the query
              $res2=mysqli_query($conn, $sql2);
            //count rows to check whether the category is available or not
             $count2=mysqli_num_rows($res2);
        
              if($count2>0)
              {
               //product Available
               while($row=mysqli_fetch_assoc($res2))
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

                <?php ;
                     //check whether image is available or not
                     if($image_name=="")
                     {
                         //display message
                         echo "<div class='error'>Image Not Available.</div>";
                     }
                     else
                     {
                          //image Available
                        ?>
                <img src="<?php echo SITEURL;?>images/product/<?php echo $image_name;?>" alt=""
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
                echo "<div class=error>Product are Not Available.</div>";
              }
            ?>
        <div class="clearfix"></div>
    </div>
    <p class="text-center">
        <a href="<?php echo SITEURL; ?>product.php">See all products</a>
    </p>
</section>
<!-- product Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>