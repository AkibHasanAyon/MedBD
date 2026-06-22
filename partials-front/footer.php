<!-- social Section Ends Here -->
<footer id="footer" class="section-p1">
    <div class="col">
        <h4>Contact</h4>
        <p><Strong>Address:</Strong> 357/B, Block-D, Bashundhara R/A, Dhaka (Close to Apollo Hospital) </p>
        <p><Strong>Phone:</Strong> 098-7654-321 </p>
        <p><Strong>Email:</Strong> Contact@medbd.com </p>
        <div class="follow">
            <h4>follow Us</h4>
            <div class="icon">
                <i class='bx bxl-facebook'></i>
                <i class='bx bxl-twitter'></i>
                <i class='bx bxl-instagram'></i>
                <i class='bx bxl-pinterest'></i>
                <i class='bx bxl-youtube'></i>
            </div>
        </div>
    </div>
    <div class="col">
        <h4>About</h4>
        <a href="#">About Us</a>
        <a href="#">Delivery information</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms & Conditions</a>
        <a href="<?php echo SITEURL; ?>contact.php">Contact Us</a>
    </div>
    <div class="col">
        <h4>My Account</h4>
        <?php if(isset($_SESSION['customer_id'])): ?>
            <a href="<?php echo SITEURL; ?>customer/profile.php">My Profile</a>
            <a href="<?php echo SITEURL; ?>cart.php">View Cart</a>
            <a href="<?php echo SITEURL; ?>wishlist.php">My Wishlist</a>
            <a href="<?php echo SITEURL; ?>customer/my-orders.php">Track My Order</a>
            <a href="<?php echo SITEURL; ?>customer/logout.php">Logout</a>
        <?php else: ?>
            <a href="<?php echo SITEURL; ?>customer/login.php">Sign In</a>
            <a href="<?php echo SITEURL; ?>customer/register.php">Register</a>
        <?php endif; ?>
    </div>

    <div class="col install">
        <h4>Install App</h4>
        <p>From App Store or Google Play</p>
        <div class="row">
            <img src="<?php echo SITEURL; ?>images/pay/app.jpg" alt="">
            <img src="<?php echo SITEURL; ?>images/pay/play.jpg" alt="">
        </div>
        <p>Secure Payment Gateways</p>
        <img src="<?php echo SITEURL; ?>images/pay/pay2.png" alt="">
    </div>
    <div class="copyright">
        <p> Copyright &copy;-2022 All rights reserved by MedBD</p>
    </div>
</footer>

</body>

</html>