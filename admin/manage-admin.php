<?php include('partials/menu.php') ?>
<!-- main -->
<div class="main-content">
    <div class="wrapper ">


        <h1>Manage Admin</h1>

        <br>
        <?php 
           
           if(isset($_SESSION['add']))
           {
             echo $_SESSION['add'];//Displaying session message
             unset($_SESSION['add']);//removing session message
           }
           
           if(isset($_SESSION['delete']))
           {
             echo $_SESSION['delete'];//Displaying session message
             unset($_SESSION['delete']);//removing session message
           }

              
           if(isset($_SESSION['update']))
           {
             echo $_SESSION['update'];//Displaying session message
             unset($_SESSION['update']);//removing session message
           }

           if(isset($_SESSION['user-not-found']))
           {
             echo $_SESSION['user-not-found'];//Displaying session message
             unset($_SESSION['user-not-found']);//removing session message
           }

           if(isset($_SESSION['pwd-not-match']))
           {
             echo $_SESSION['pwd-not-match'];//Displaying session message
             unset($_SESSION['pwd-not-match']);//removing session message
           }

           if(isset($_SESSION['change-pwd']))
           {
             echo $_SESSION['change-pwd'];//Displaying session message
             unset($_SESSION['change-pwd']);//removing session message
           }
           ?>
        <br><br><br>
        <!-- button to add admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br> <br> <br>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>User Name</th>
                <th>Actions</th>
            </tr>

            <?php 
              //query to get all admin
              $sql="SELECT * FROM tbl_admin";
              //execute the query
              $res=mysqli_query($conn,$sql);
              //check whether the query is executed or not  
              

              if($res==TRUE)
              {
                //count rows to check whether we have database or not
                $count=mysqli_num_rows($res);//Fuction to get rows of database

                $sn=1;//Create a variable and assign the value
                //check the number of rows
                if($count>0)
                {
                  //we have data in dtabase
                  while($rows=mysqli_fetch_assoc($res))
                  {
                    //using While loop to get all the data from database
                    //And while loop will run as long as we have data in our database
                    //Get individual data
                    $id=$rows['id'];
                    $full_name=$rows['full_name'];
                    $username=$rows['username'];
                    //display the values in our table

            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $username; ?></td>
                <td>

                    <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>"
                        class="btn-primary">Change Password</a>
                    <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">
                        update admin</a>
                    <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">
                        Delete admin</a>
                </td>
            </tr>

            <?php 


                  }
                }
                else{
                  //We do not have data on database
                }
              }



           ?>

        </table>
    </div>
</div>
<!-- footer -->

<?php include('partials/footer.php') ?>