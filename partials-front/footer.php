<!-- social Section Ends Here -->
<footer id="footer">
    <div class="container footer-content">
        <div class="col">
            <h4>Contact</h4>
            <p><Strong>Address:</Strong> 357/B, Block-D, Bashundhara R/A, Dhaka (Close to Apollo Hospital) </p>
            <p><Strong>Phone:</Strong> 098-7654-321 </p>
            <p><Strong>Email:</Strong> Contact@medbd.com </p>
            <div class="follow">
                <h4>Follow Us</h4>
                <div class="social-icons">
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
            <a href="<?php echo SITEURL; ?>pages/contact.php">Contact Us</a>
        </div>
        <div class="col">
            <h4>My Account</h4>
            <?php if(isset($_SESSION['customer_id'])): ?>
                <a href="<?php echo SITEURL; ?>customer/profile.php">My Profile</a>
                <a href="<?php echo SITEURL; ?>cart/">View Cart</a>
                <a href="<?php echo SITEURL; ?>wishlist/">My Wishlist</a>
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
            <div class="row" style="margin-bottom: 15px;">
                <img src="<?php echo SITEURL; ?>images/pay/app.jpg" alt="App Store" style="border: 1px solid #15c293; border-radius: 6px; margin-right: 5px;">
                <img src="<?php echo SITEURL; ?>images/pay/play.jpg" alt="Play Store" style="border: 1px solid #15c293; border-radius: 6px;">
            </div>
            <p>Secure Payment Gateways</p>
            <img src="<?php echo SITEURL; ?>images/pay/pay2.png" alt="Payment Gateways" style="max-width: 100%;">
        </div>
    </div>
    <div class="copyright">
        <p> Copyright &copy; <?php echo date('Y'); ?> All rights reserved by MedBD</p>
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchBoxes = document.querySelectorAll(".search-box");
    
    searchBoxes.forEach(function(box) {
        const input = box.querySelector("input[type='search']");
        if (!input) return;

        // Automatically append suggestions container inside search box
        const suggestionDiv = document.createElement("div");
        suggestionDiv.className = "search-suggestions";
        box.appendChild(suggestionDiv);

        let debounceTimer;

        input.addEventListener("input", function() {
            clearTimeout(debounceTimer);
            const query = this.value.trim();

            if (query.length < 1) {
                suggestionDiv.style.display = "none";
                suggestionDiv.innerHTML = "";
                return;
            }

            debounceTimer = setTimeout(function() {
                fetch("<?php echo SITEURL; ?>catalog/suggest-product.php?q=" + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        suggestionDiv.innerHTML = "";
                        if (data.length === 0) {
                            suggestionDiv.innerHTML = '<div class="no-suggestion">No matching products found</div>';
                        } else {
                            data.forEach(function(item) {
                                const link = document.createElement("a");
                                link.href = item.url;
                                link.className = "suggestion-item";
                                link.innerHTML = `
                                    <img src="${item.image}" alt="${item.title}" class="suggestion-img">
                                    <div class="suggestion-details">
                                        <span class="suggestion-title">${item.title}</span>
                                        <span class="suggestion-price">৳${item.price}</span>
                                    </div>
                                `;
                                suggestionDiv.appendChild(link);
                            });
                        }
                        suggestionDiv.style.display = "block";
                    })
                    .catch(err => {
                        console.error("Error fetching search suggestions:", err);
                    });
            }, 200);
        });

        // Restore suggestions dropdown if user re-focuses on input field
        input.addEventListener("focus", function() {
            if (this.value.trim().length >= 1 && suggestionDiv.innerHTML !== "") {
                suggestionDiv.style.display = "block";
            }
        });

        // Hide suggestions when clicking outside the search box
        document.addEventListener("click", function(e) {
            if (!box.contains(e.target)) {
                suggestionDiv.style.display = "none";
            }
        });
    });
});
</script>
</body>

</html>