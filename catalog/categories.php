<?php include('../partials-front/menu.php'); ?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">All Categories</h2>

        <div class="category-grid">
            <?php
              $sql ="SELECT * FROM tbl_category WHERE active='Yes'";
              $res=mysqli_query($conn, $sql);

              if(mysqli_num_rows($res)>0)
              {
                  while($row=mysqli_fetch_assoc($res))
                  {
                      $id=$row['id'];
                      $title=$row['title'];
                      $image_name=$row['image_name'];
                      ?>
                    <a href="<?php echo SITEURL;?>category-product.php?category_id=<?php echo $id ?>" class="category-card">
                        <?php if($image_name==""): ?>
                            <div style="background: #eee; height: 100%; display:flex; align-items:center; justify-content:center;">No Image</div>
                        <?php else: ?>
                            <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt="<?php echo $title; ?>">
                        <?php endif; ?>
                        <div class="category-title"><?php echo $title; ?></div>
                    </a>
                    <?php
                  }
              }
              else
              {
                  echo "<div class='error text-center'>Categories Not Available.</div>";
              }
            ?>
        </div>

    </div>
</section>
<!-- Categories Section Ends Here -->


<?php include('../partials-front/footer.php'); ?>