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


<!-- Hero / Search Section -->
<section class="hero-section" style="padding: 4% 0;">
    <div class="container">
        <h1><?php echo htmlspecialchars($category_title); ?></h1>
    </div>
</section>

<!-- Product Menu Section -->
<section class="product-menu">
    <div class="container">
        <h2 class="text-center">Products in <?php echo htmlspecialchars($category_title); ?></h2>
        
        <div class="product-grid">
            <?php 
            $sql2="SELECT * FROM tbl_product WHERE category_id=$category_id";
            $res2=mysqli_query($conn, $sql2);
            if(mysqli_num_rows($res2) > 0) {
                while($row=mysqli_fetch_assoc($res2)) {
                    $id=$row['id'];
                    $title=$row['title'];
                    $price=$row['price'];
                    $description=$row['description'];
                    $image_name=$row['image_name'];
                    ?>
                    <div class="product-card">
                        <div class="product-img">
                            <?php if($image_name == ""): ?>
                                <div style="background: #eee; height: 100%; display:flex; align-items:center; justify-content:center;"><i class='bx bx-image text-muted' style="font-size:30px;"></i></div>
                            <?php else: ?>
                                <img src="<?php echo SITEURL;?>images/product/<?php echo $image_name;?>" alt="<?php echo $title; ?>">
                            <?php endif; ?>
                        </div>

                        <div class="product-info">
                            <a href="<?php echo SITEURL; ?>product-detail.php?id=<?php echo $id; ?>">
                                <div class="product-title"><?php echo $title; ?></div>
                            </a>
                            
                            <?php
                                $rate_sql = "SELECT AVG(rating) as avg_rate FROM tbl_review WHERE product_id=$id";
                                $rate_res = mysqli_query($conn, $rate_sql);
                                $rate_row = mysqli_fetch_assoc($rate_res);
                                $avg_rate = $rate_row['avg_rate'] ? round($rate_row['avg_rate'], 1) : 0;
                            ?>
                            <div style="color: #ffb300; font-size: 14px; margin-bottom: 8px;">
                                <?php 
                                    for($i=1; $i<=5; $i++) {
                                        if ($i <= round($avg_rate)) echo "★";
                                        else echo "☆";
                                    }
                                ?>
                                <span style="color: var(--text-muted); font-size: 12px; margin-left: 5px;">(<?php echo $avg_rate; ?>)</span>
                            </div>

                            <div class="product-price">৳<?php echo number_format($price, 2); ?></div>
                            <div class="product-desc"><?php echo $description; ?></div>
                            
                            <div class="product-actions">
                                <a href="<?php echo SITEURL; ?>add-to-cart.php?product_id=<?php echo $id; ?>" class="btn-icon" title="Add to Cart">
                                    <i class='bx bx-cart-add' style="font-size: 22px;"></i>
                                </a>
                                <a href="<?php echo SITEURL; ?>order.php?product_id=<?php echo $id; ?>" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='error text-center'>No products found in this category.</div>";
            }
            ?>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>