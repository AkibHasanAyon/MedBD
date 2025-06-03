<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper w">
        <h1>Add Admin</h1>

        <br><br>

        <?php 
           
           if(isset($_SESSION['add'])) //Checking whether the session is set or not
           {
             echo $_SESSION['add'];//Displaying session message
             unset($_SESSION['add']);//removing session message
           }
           
           ?>


        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>



    </div>
</div>
<?php include('partials/footer.php') ?>


<?php 
  //process the value of from and save it in Database
  //check whether the submit button is clicked or not

  if(isset($_POST['submit']))
{
    //Button Clicked
    // echo'Button Clicked';

   //1.Get the data from form

     $full_name=$_POST['full_name'];
     $username=$_POST['username'];
     $password=md5($_POST['password']);//password encryption with MD5

   //2.Sql Query to save the data into database
   $sql="INSERT INTO tbl_admin SET
      full_name='$full_name',
      username='$username',
      password='$password'
   ";

//    echo $sql;

//3.Execute the theory and save the data into Database
//    $conn=mysqli_connect('localhost','root','') or die(mysqli_error());//database connection
//    $db_select=mysqli_select_db($conn,'product-order') or die(mysqli_error());//delecting database


   $res=mysqli_query($conn,$sql) or die(mysqli_error());

   //4.Check whether the (query is cexecuted) data is inserted or not and display appropriate message
   if($res==TRUE)
   {
       //Data Inserted
       //echo"Data Inserted";
      //create a session variable to display message

      $_SESSION['add']="Admin Added Successfully";

    //Redirect page to manage admin
      header("location:".SITEURL.'admin/manage-admin.php');


   }
   else
   {
       //failed to insert the data
        //    echo"Data NOT Inserted";

     //create a session variable to display message

     $_SESSION['add']="Failed TO Add Admin";

     //Redirect page to Add Admin
       header("location:".SITEURL.'admin/add-admin.php');

   }

}

?>