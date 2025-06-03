<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Product</h1>

        <br><br>

        <?php
        ob_start();
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }     
        
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
    ?>

        <form action="" method="POST" enctype='multipart/form-data'>

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Title of the Product"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5"
                            placeholder="Description of the page"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price"></td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                                //create sql code to display category from data base
                                //1.create sql to get all active from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                //execute query
                                $res = mysqli_query($conn, $sql);

                                //count rows whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //if count is greater then zero we have categories
                                if($count > 0)
                                {
                                    // we have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>

                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                            <?php
                                    } 
                                }
                                else
                                {
                                    // we don't have categories
                                    ?>
                            <option value="0">No Category Found</option>
                            <?php
                                }

                                //2.Display a dropdown
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Product" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add product form  ends -->

        <?php
           
        //    check whether the button is clicked or not 
        if(isset($_POST['submit']))
        {
            //add product in the database
            // echo "clicked"; 

            // 1.get data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

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
            $title = str_replace("'","\'",$title);
            $description = str_replace("'","\'",$description);
            $sql2 = "INSERT INTO tbl_product  SET
                title = '$title',
                description = '$description',
                price = $price,
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