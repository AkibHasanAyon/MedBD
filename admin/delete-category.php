<?php
    //include constants file
    include('../config/constants.php');
    // echo "Delete page";
    // check whether the id or image is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        // echo 'Get value and delete';
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove physical image file if available
        if($image_name !="")
        {
            //image is available remove it
            $path = '../images/category/'.$image_name;
            //remove name
            $remove = unlink($path);
            
            //if failed to remove image then add error message and stop the process
            if($remove == false)
            {
                //set the session message
                $_SESSION['remove'] = "<div class='error'>Failed to remove Image.</div>";
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop the process
                die();
            }
        }
        //delete data from database
        //sql query to delte data from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the data is deleted from the database or not
        if($res == true)
        {
            //set success message and redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
            //redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
            
        }
        else
        {
            //set fail message and redirect
             $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
             //redirect to manage category
             header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else
    {
        //redirect to manage catagory page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>