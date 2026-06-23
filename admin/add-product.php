<?php include('partials/menu.php');?>

    <div class="wrapper">
        <h1 class="page-title">Add Product</h1>

        <?php
        ob_start();
        if(isset($_SESSION['upload'])) { echo $_SESSION['upload']; unset($_SESSION['upload']); }     
        if(isset($_SESSION['add'])) { echo $_SESSION['add']; unset($_SESSION['add']); }
        ?>

        <div class="form-container">
            <form action="" method="POST" enctype='multipart/form-data'>
                <table class="tbl-30">
                    <tr>
                        <td>Title</td>
                        <td><input type="text" name="title" placeholder="Product Title" required></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 20px;">Description</td>
                        <td><textarea name="description" cols="30" rows="4" placeholder="Product Description"></textarea></td>
                    </tr>
                    <tr>
                        <td>Price (৳)</td>
                        <td><input type="number" name="price" step="0.01" required></td>
                    </tr>
                    <tr>
                        <td>Stock Quantity</td>
                        <td><input type="number" name="stock_qty" value="50" min="0" required></td>
                    </tr>
                    <tr>
                        <td>Product Image</td>
                        <td><input type="file" name="image" accept="image/*"></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>
                            <select name="category">
                                <?php
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    $res = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($res);
                                    if($count > 0) {
                                        while($row=mysqli_fetch_assoc($res)) {
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            echo "<option value='$id'>$title</option>";
                                        } 
                                    } else {
                                        echo "<option value='0'>No Category Found</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Featured</td>
                        <td>
                            <label style="margin-right: 15px;"><input type="radio" name="featured" value="Yes"> Yes</label>
                            <label><input type="radio" name="featured" value="No" checked> No</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Active</td>
                        <td>
                            <label style="margin-right: 15px;"><input type="radio" name="active" value="Yes" checked> Yes</label>
                            <label><input type="radio" name="active" value="No"> No</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 25px;">
                            <button type="submit" name="submit" class="btn-primary" style="width: 100%;"><i class='bx bx-plus-circle'></i> Add Product</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <?php
           
        //    check whether the button is clicked or not 
        if(isset($_POST['submit']))
        {
            //add product in the database
            // echo "clicked"; 

            // 1.get data from form
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);
            $stock_qty = (int)$_POST['stock_qty'];
            $category = (int)$_POST['category'];

            //check wheter the radio button for featured and active are checked or not
            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else
            {
                $featured = 'No';// set default value
            }
            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = 'No';// set default value
            }

            // 2.upload the image if selected
            //check whether the select image is clicked or not and upload image only if image is selcected
            if(isset($_FILES['image']['name']))
            {
                //get the details of the selected image
                $image_name = $_FILES['image']['name'];

                // check wheter the image is selected or not and upload image only if selcected
                if($image_name !="")
                {
                    // image is selected
                    // A. we need to rename the image
                    // get extention of the selected image
                    $ext = end(explode('.', $image_name));

                    // Create new name for image 
                    $image_name = 'Product-Name_'.rand(000,99999).'.'.$ext;// new name may be Product-Name_93.jpg
                    
                    //B. upload the image
                    // get the source path and destination path
                    
                    //source path is the current location path of the image
                    $src = $_FILES['image']['tmp_name'];
                    
                    //destination path for the image to be uploaded
                    $dst = "../images/product/".$image_name;

                    //finally upload the image
                    $upload = move_uploaded_file($src, $dst);
                
                   if($upload == false)
                    {
                        //failed to upload
                        
                        //redirect to add product page with eror message
                        $_SESSION['upload'] = '<div class = "error">Failed to upload image.</div>';
                        header('location:'.SITEURL.'admin/add-product.php');
                        //stop the process
                        die();
                    }
                }
            }
            else
            {
                $image_name = "";
            }
            

            // 3. insert into database

            // Create sql query to save or add data to database
            // for numerical value we don't need pass value inside "" but for string value it is compulsory
            $sql2 = "INSERT INTO tbl_product  SET
                title = '$title',
                description = '$description',
                price = $price,
                stock_qty = $stock_qty,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
            ";
            
            //execute the query
            $res2 = mysqli_query($conn, $sql2);
            // check whether the data is inserted or not

            if($res2 == true)
            {
                //data inserted successfully
                $_SESSION['add'] = "<div class = 'success'>Product Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-product.php');
            }
            else
            {
                //failed to insert data
                $_SESSION['add'] = "<div class = 'error'>Failed to Add Product.</div>";
                header('location:'.SITEURL.'admin/add-product.php');
            }
            // 4. redirect to messge to manage product

        } 
        ob_end_flush();

        ?>

    </div>
</div>

<?php include("partials/footer.php")?>