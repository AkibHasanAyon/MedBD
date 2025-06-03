<?php include('partials-front/menu.php'); ?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center color-primary">Categories</h2>


        <?php
             
              //Display all the categories that are active
              //SQL Query
              $sql ="SELECT * FROM tbl_category WHERE active='Yes'";

              //Execute the query
              $res=mysqli_query($conn, $sql);
              //Count ROWS
              $count =mysqli_num_rows($res);
              //Check whether categories available or not

              if($count>0)
              {
                  //categories available
                  while($row=mysqli_fetch_assoc($res))
                  {
                      //Get the Values like id,title,image_name
                      $id=$row['id'];
                      $title=$row['title'];
                      $image_name=$row['image_name'];

                      ?>
        <a href="<?php echo SITEURL;?>category-product.php?category_id=<?php echo $id ?>">
            <div class="box-3 float-container">
                <?php 
                             if($image_name=="")
                             {
                                 //display message
                                 echo "<div class='error'>Image Not Available.</div>";
                             }
                             else
                              {
                                   //image Available
                                 ?>
                <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt="medicine "
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
                  //categories Not Available
                  echo "<div class='error'>Categories Not Available.</div>";
              }

           ?>



        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->


<?php include('partials-front/footer.php'); ?>