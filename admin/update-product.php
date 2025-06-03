<?php include("partials/menu.php")?>

<?php
ob_start();
            
            // check whether the id is set or not
            if(isset($_GET['id']))
            {
                // get the id and all the details
                $id = $_GET['id'];
                
                //create sql query to get all other details
                $sql2 = "SELECT * FROM tbl_product WHERE id=$id";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //get the value based on query executed
                $row2 = mysqli_fetch_assoc($res2);

                //get the individual value of selected Product
                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $current_image = $row2['image_name'];
                $current_category =$row2['category_id'];
                $featured = $row2['featured'];
                $active = $row2['active'];
            }
            else
            {
                //redirect to manage product
                header('location:'.SITEURL.'admin/manage-product.php');
            }

        ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Product</h1>
        <br><br>


        <form action="" method="post" enctype='multipart/form-data'>

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name=" description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image == "")
                            {
                                //image not available
                                echo '<div class = "error">Image not available.</div>';
                            }
                            else
                            {
                                //image available
                                ?>
                        <img src="<?php echo SITEURL;?>images/product/<?php echo $current_image;?>" width='100px'>
                        <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            //query to get active categories
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //execute the queries
                                $res = mysqli_query($conn, $sql);
                                //count rows
                                $count = mysqli_num_rows($res);

                                //check whether category available or not
                                if($count>0)
                                {
                                    //category available
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        // echo "<option value = '$category_id'>$category_title</option>";
                                        ?>
                            <option <?php if($current_category ==$category_id){echo "selected";} ?>
                                value="<?php echo $category_id; ?>">
                                <?php echo $category_title; ?></option>
                            <?php

                                    } 
                                }
                                else
                                {
                                    //category not available
                                    echo "<option value='0'>Category Not Available</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes"){echo "checked";}?> type="radio" name="featured"
                            value="Yes">Yes
                        <input <?php if($featured == "No"){echo "checked";}?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active == "No"){echo "checked";}?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Product" class="btn-secondary">
                    </td>
                </tr>


            </table>

        </form>

        <?php

            if(isset($_POST['submit']))
            {
                // echo "clicked";
                // 1.get all the details from the form

                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
            
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2.upload the new image if selected
                //check whether the upload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    //upload button clicked
                    $image_name = $_FILES['image']['name'];//new image name

                    //check whether the image is available or not
                    if($image_name != "")
                    {
                        //image available 

                        //auto rename our image
                        //get the extension like(jpg, png, gif, etc)
                        $exp = explode('.', $image_name);
                        $ext = end($exp);

                        // rename the image 
                        $image_name = 'Product-Name_'.rand(000,99999).'.'.$ext;
    
                        //get the source path and destination
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/product/".$image_name;
                
                        //upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);
    
                        //check whether image is uploaded or not
                        // And if the image is not uploaded we will stop the process and redirect with error message
                        if($upload == false)
                        {
                            $_SESSION['upload'] = '<div class = "error">Failed to upload image.</div>';
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/manage-product.php');
                            //stop the process
                            die();
                        }
            
                    // 3. remove the current image if new image is selected and current image exist
                        if($current_image != "")
                        {
                            $remove_path = "../images/product/".$current_image;

                            $remove = unlink($remove_path);
        
                        // check wheter the image is removed or not

                            //if failed to remove display message and stop the process
                            if($remove == false)
                            {
                                //failed to remove image
                                $_SESSION['failed-remove'] = '<div class = "error">Failed to remove current image.</div>';
                                header('location:'.SITEURL.'admin/manage-product.php');
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                // 4.update the data in the database

                $title = str_replace("'","\'",$title);
                $description = str_replace("'","\'",$description);

                $sql3 = "UPDATE tbl_product SET 
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id = '$id'
                ";

                //execute the query
                $res3 = mysqli_query($conn, $sql3);

                //redirect to manage category with session massage
                //check query executed or not
                if($res3 == true)
                {
                    //Product updated
                    $_SESSION['update'] = "<div class = 'success'>Product Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-product.php');
                }
                else
                {
                    //failed to update product
                    $_SESSION['update'] = "<div class = 'success'>Failed to update product.</div>";
                    header('location:'.SITEURL.'admin/manage-product.php');
                }
            }
        
            ob_end_flush();
        ?>

    </div>
</div>


<?php include("partials/footer.php");?>