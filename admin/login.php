<?php include('../config/constants.php'); ?>

<html>

<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/adminstyle.css">
    <title>Login - Product Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    <div class="login">
        <h1 class="text-center">Login</h1>
        <br> <br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br> <br>

        <!-- login form starts here -->
        <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"> <br> <br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"> <br> <br>

           
           
             <button class="btn btn-background-slide"> <input type=submit name=submit value=Login </button>

            <br> <br>
        </form>
      

    </div>
    
        

</body>

</html>



<?php

//Check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    //Process for login
    //1. Get the Data from login from
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //2. SQL to check whether the user with username and password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

    //3. Execute the query

    $res = mysqli_query($conn, $sql);

    //4. Count rows to check whether the user exists or not
    $count = mysqli_num_rows($res);

    if ($count == 1) {

        //User Available and login success
        $_SESSION['login'] = "<div class='success'> Login Successful. </div>";
        $_SESSION['user'] = $username; // To check whether the user is logged in or not and logout will unset it.

        // Redirect to home page
        header('Location:'.SITEURL.'admin/');
    } else {

        //User Not Available
        $_SESSION['login'] = "<div class='error text-center'> Username or Password didnot matched. Try again. </div>";
        // Redirect to login page
        header('Location:'.SITEURL.'admin/login.php');
    }
}

?>