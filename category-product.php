<?php include('partials-front/menu.php'); ?>

<?php
       //Check whether id is passed or not
       if(isset($_GET['category_id']))
       {
           //category id set and get the id
           $category_id=(int)$_GET['category_id'];
           //Get the category title based on category id

           $sql="SELECT title FROM tbl_category WHERE id=$category_id";
         

          //Execute the query
          $res=mysqli_query($conn, $sql);
          //get the values from database
          $row=mysqli_fetch_assoc($res);

          //Get the title
          $category_title=$row['title'];




       }
       else
       {
           //category passed
           //Redirect to home page 
           header('location:'.SITEURL);
       }


   ?>


<!-- product sEARCH Section Starts Here -->
<section class="product-search text-center">
    <div class="container">

        <h2><a href="#" class="text-white"><?php echo $category_title;?></a></h2>

    </div>
</section>
<!-- product sEARCH Section Ends Here -->



<!-- product MEnu Section Starts Here -->
<section class="product-menu">
    <div class="container">
        <h2 class="text-center">Product Menu</h2>
        <?php
                  //create SQL Query to get product on selected category
                  $sql2="SELECT * FROM tbl_product WHERE category_id=$category_id";

                      
                   //Execute the query
                   $res2=mysqli_query($conn, $sql2);
                   //count rows to check whether the category is available or not
                    $count2=mysqli_num_rows($res2);
                if($count2>0)
                {
                        //Product Available
                    while($row2=mysqli_fetch_assoc($res2))
                      {
                         //get all the values
                         $id=$row2['id'];
                         $title=$row2['title'];
                         $price=$row2['price'];
                         $description=$row2['description'];
                        $image_name=$row2['image_name'];

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
                <img src="<?php echo SITEURL;?>images/product/<?php echo $image_name;?>" alt=""
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
                else
                {
                    //product NOT AVAILABLE
                    echo"<div class=error>Product Not Available.</div>";
                }

             ?>



        <div class="clearfix"></div>



    </div>

</section>
<!-- product Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>