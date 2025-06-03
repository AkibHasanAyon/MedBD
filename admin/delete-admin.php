<?php 

   //Include Constraints.php file here
   include('../config/constants.php');
 
 //1.get the id of the admin to be deleted
    $id = $_GET['id'];
 //2.create SQL query to delete admin
  $sql = "DELETE FROM tbl_admin WHERE id=$id";
  //Execute the query
   $res=mysqli_query($conn, $sql);

   //Check whether the query is successfully excuted or not
   if($res==TRUE)
   {
       //query Executed successfully and admin deleted 
    //    echo"Admin Deleted";
    //Create Session Variable to display Message

    $_SESSION['delete']="<div class='success'>Admin deleted successfully</div>";
    //Redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
   
   }
   else{
       //failed to delete admin
    //    echo"failed to delete admin";

    $_SESSION['delete']="<div class='error'>Failed To delete Item.Try Again.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
   }
 //3.Redirect to manage Admin page with message(success/error)


?>