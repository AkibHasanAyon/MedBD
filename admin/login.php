<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedBD Admin Login</title>
    <link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            background: var(--white);
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-header {
            margin-bottom: 30px;
        }
        .login-header h2 {
            color: var(--primary);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .login-header p {
            color: var(--text-muted);
            font-size: 15px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        .btn-login {
            background: var(--primary);
            color: var(--white);
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover {
            background: var(--primary-hover);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <h2>MEDbd</h2>
            <p>Admin Control Panel</p>
        </div>

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

        <form action="" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>
            <button type="submit" name="submit" class="btn-login">Login to Dashboard</button>
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