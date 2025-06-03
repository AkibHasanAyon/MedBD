<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">

        <h1>Manage Product</h1>
        <br><br> <br>
        <a href="<?php echo SITEURL; ?>admin/add-product.php" class="btn-primary">Add product</a>
        <br> <br> <br>

        <?php
        
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['unauthorize']))
        {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }

        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
            
            <?php
                //Create sql to get the data
                $sql = "SELECT * FROM tbl_product";

                //execute query
                $res = mysqli_query($conn, $sql);

                //count rows to check whether we have data or not
                $count = mysqli_num_rows($res);

                //create serial number variable and assgn value 1
                $sn = 1;
                
                if($count>0)
                {
                  //we have data in database 
                  // get the data display
                  while($row=mysqli_fetch_assoc($res))
                  {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>

            <tr>
                <td><?php echo $sn++;?>.</td>
                <td><?php echo $title;?></td>
                <td><?php echo $price;?></td>

                <td>
                    <?php 
                    // check image name is available or not
                    if($image_name == "")
                    {
                      echo "<div class ='error'>Image not added.</div>";
                      
                    }
                    else
                    {
                      //display image
                    ?>

                    <img src="<?php echo SITEURL;?>images/product/<?php echo $image_name;?>" width='60px'>

                    <?php

                    }
                    ?>
                </td>

                <td><?php echo $featured;?></td>
                <td><?php echo $active;?></td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-product.php?id=<?php echo $id; ?>"
                        class="btn-secondary">Update Product</a>
                    <a href="<?php echo SITEURL; ?>admin/delete-product.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>"
                        class="btn-danger">Delete
                        Product</a>
                </td>

                <?php
                  }
                }
                else
                {
                  // we donot have data 
                  echo "<tr><td colspan ='7' class='error'>Product not Added Yet. <td></tr>";
                }


            ?>


            </tr>
        </table>

        <!-- <div class="clearfix"></div> -->
    </div>
</div>

<?php include('partials/footer.php') ?>