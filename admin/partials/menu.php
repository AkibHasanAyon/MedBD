<?php 
include('../config/constants.php'); 
include('login-check.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDbd</title>
    <link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">
</head>

<body>
    <h1 class="text-center">Admin Panel</h1>
    <!-- Menu -->
    <div class="menu text-right">
    <style>
/* Style The Dropdown Button */
.dropbtn {
  background-color: transparent;
  color: #155e58;
  padding: 16px;
  font-size: 20px;
  font-weight: bold;
  border: none;
  cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: #155e58;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover 
{
    background-color: #f1f1f1;
    font-weight: bold;

}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
  background-color: transparent;
  color: #15c293;

}
</style>

<div class="dropdown">
  <button class="dropbtn">Menu ≡</button>
  
  <div class="dropdown-content">
    
                
                  
                <a href="index.php">Home</a>
                <a href="manage-admin.php">Admin</a>
                <a href="manage-category.php">Category</a>
                <a href="manage-product.php">Product</a>
                <a href="manage-order.php">Order</a>
                
         
  </div>
  
    </div>

    <style>

.btn-text-right{
	text-align: right;
    padding: 0px 10px;

}
</style>

<div class="btn-text-right">

  	<button type="button" class="btn btn-primary"><a href="logout.php">LOGOUT</a></button>
</div>