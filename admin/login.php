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
    //1. Get the Data from login form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $raw_password = $_POST['password'];

    //2. SQL to get the admin by username only (password checked in PHP)
    $sql = "SELECT * FROM tbl_admin WHERE username = '$username'";

    //3. Execute the query
    $res = mysqli_query($conn, $sql);

    //4. Count rows to check whether the user exists or not
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $stored_password = $row['password'];
        $login_success = false;

        // Try bcrypt first (new format)
        if (password_verify($raw_password, $stored_password)) {
            $login_success = true;
        }
        // Fallback: try MD5 (legacy format) and upgrade if matched
        elseif (md5($raw_password) === $stored_password) {
            $login_success = true;
            // Upgrade the password to bcrypt
            $new_hash = password_hash($raw_password, PASSWORD_BCRYPT);
            $upgrade_sql = "UPDATE tbl_admin SET password='" . mysqli_real_escape_string($conn, $new_hash) . "' WHERE id=" . (int)$row['id'];
            mysqli_query($conn, $upgrade_sql);
        }

        if ($login_success) {
            //User Available and login success
            $_SESSION['login'] = "<div class='success'> Login Successful. </div>";
            $_SESSION['user'] = $username; // To check whether the user is logged in or not and logout will unset it.

            // Redirect to home page
            header('Location:'.SITEURL.'admin/');
        } else {
            //Wrong password
            $_SESSION['login'] = "<div class='error text-center'> Username or Password didnot matched. Try again. </div>";
            // Redirect to login page
            header('Location:'.SITEURL.'admin/login.php');
        }
    } else {

        //User Not Available
        $_SESSION['login'] = "<div class='error text-center'> Username or Password didnot matched. Try again. </div>";
        // Redirect to login page
        header('Location:'.SITEURL.'admin/login.php');
    }
}

?>