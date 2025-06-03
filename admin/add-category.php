<?php include("partials/menu.php")?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>


        <!-- Add Category form starts -->
        <form action="" method="POST" enctype='multipart/form-data'>

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Category title"></td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Category form  ends -->

        <?php
           
        //    check whether the submit button is clicked or not
        if(isset($_POST['submit']))
        {
             echo "clicked";

            // 1. get the value from category form
             $title = $_POST['title'];

            // for radio input we need to check button is selected or not 
            if(isset($_POST['featured']))
            {
                //get the value
                $featured = $_POST['featured'];
            }
            else
            {
                // set the default value 
                $featured = "No";
            }

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No";
            }

            // check whether the image is selected or not and set the value for image name accordingly
            // print_r($_FILES['image']);
            
            // die();//break the code here
            
            if(isset($_FILES['image']['name']))
            {
                //upload the image
                // to upload the image we need name, source path and destination path
                $image_name = $_FILES['image']['name'];
                
                //upload image only if image is selected
                if($image_name != "")
                {
                    //auto rename our image
                    //get the extension like(jpg, png, gif, etc)
                    $ext = end(explode('.', $image_name));

                    // rename the image 
                    $image_name = 'Category_'.rand(000,99999).'.'.$ext;
                
                    $source_path = $_FILES['image']['tmp_name'];
                
                    $destination_path = "../images/category/".$image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);
                
                    //check whether image is uploaded or not
                    // And if the image is not uploaded we will stop the process and redirect with error message
                    if($upload == false)
                    {
                        $_SESSION['upload'] = '<div class = "error">Failed to upload image.</div>';
                        //redirect to add category page
                        header('location:'.SITEURL.'admin/add-category.php');
                        //stop the process
                        die();
                    }
                
                }
                
                
            }
            else
            {
                //don't upload image and set the image name value to blank
                $image_name = "";
            }
            //checking quatation and replacing it \'
            $title = str_replace("'","\'",$title);
            //2. create sql query to insert data in the database

            $sql = "INSERT INTO tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
            ";

            //3. execute the query and save in the database
            $res = mysqli_query($conn, $sql);
           
            //4. whether the query executed or not and data added or not
            if($res==true)
            {
                //Query executed and category added
                $_SESSION['add'] = "<div class = 'success'>Category Added Successfully.</div>";
                // Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                //Failed to add category
                $_SESSION['add'] = "<div class = 'error'>Failed to Add Category.</div>";
                // Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/add-category.php');
            }
        }

        ?>

    </div>
</div>

<?php include("partials/footer.php")?>