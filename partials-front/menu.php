<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDbd</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/style2.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>


</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="images/MedBdLogo.png?v=<?php echo time();?>" alt="MEDbd Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                
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
    
                
                  
                        <a href="<?php echo SITEURL; ?>">Home</a>
                   
                   
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                   
                        <a href="<?php echo SITEURL; ?>product.php">Products</a>
                   
                        <a href="<?php echo SITEURL; ?>contact.php">Contact</a>
         
  </div>
</div>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->