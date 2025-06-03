<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        
        if(isset($_GET['id'])){
            $id=$_GET['id'];
        }
        
        
        ?>

        <form action="" method="POST">
            <!-- tbl-30  -->
            <table class="tbl_30">
                <tr>
                    <td>Current Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>


<?php 

//check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
   // echo "button Clicked";
   //1,Get All the values from form 
   $id =$_POST['id'];
   $current_password =md5($_POST['current_password']) ;
   $new_password =md5($_POST['new_password']);
   $confirm_password =md5($_POST['confirm_password']);
    
   //Check whethaer the user with current Id And Password Exists or not

   $sql="SELECT * FROM tbl_admin WHERE id='$id' AND password='$current_password' ";
  //Execute the query
   $res=mysqli_query($conn, $sql);

  //check whether the query is executed successfully or not

  if($res==true){

    //Check whether data is avilable or not
    $count=mysqli_num_rows($res);
    if($count==1)
    {
        //user exists and password can be changed
       //echo "User Found";
      //check whether the new password or confirm password matches or not
     if($new_password==$confirm_password)
     {
         //update the password
         //  echo 'password match';
         $sql2="UPDATE tbl_admin SET
          password='$new_password'
          WHERE id=$id  
          ";

        //Execute the query

         $res2=mysqli_query($conn, $sql2);

        //check whether the query executed or not
          if($res2==true)
        {
           //Display Success message
            //Redirect to Manage admin Page With Success message
           $_SESSION['change-pwd']="<div class='success'>Password Changed successfully</div>";
           //redirct the user
           header("location:".SITEURL.'admin/manage-admin.php');
  
        }
        else
        {
           //Display Error message
            //Redirect to Manage admin Page With error message
            $_SESSION['change-pwd']="<div class='error'>Failed To change Passwordx</div>";
            //redirct the user
            header("location:".SITEURL.'admin/manage-admin.php');
            
        }
     }
     else
     {
         //Redirect to Manage admin Page With error message
         $_SESSION['pwd-not-match']="<div class='error'>Password didnot match</div>";
         //redirct the user
         header("location:".SITEURL.'admin/manage-admin.php');

     }

    }
    else
    {
        //user Does not Exist Set Message and Redirect
         $_SESSION['user-not-found']="<div class='error'>User Not Found</div>";
         //redirct the user
         header("location:".SITEURL.'admin/manage-admin.php');
    }

  }
 

}




?>

<?php include('partials/footer.php') ?>