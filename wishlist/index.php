<?php include('../partials-front/menu.php'); ?>

<?php
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer-login-msg'] = "<div class='auth-message error'>Please login to view your wishlist.</div>";
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}
$customer_id = (int)$_SESSION['customer_id'];
?>

<section class="wishlist-section" style="padding: 40px 20px; max-width: 1000px; margin: 0 auto; min-height: 50vh;">
    <h2 style="color: #155e58; border-bottom: 2px solid #15c293; padding-bottom: 10px; margin-bottom: 30px;"><i class='bx bxs-heart'></i> My Wishlist</h2>

    <?php
    if (isset($_SESSION['wishlist-msg'])) {
        echo $_SESSION['wishlist-msg'];
        unset($_SESSION['wishlist-msg']);
    }
    ?>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        <?php
        $sql = "SELECT w.id as wishlist_id, p.* FROM tbl_wishlist w JOIN tbl_product p ON w.product_id = p.id WHERE w.customer_id=$customer_id";
        $res = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $wishlist_id = $row['wishlist_id'];
                $product_id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
        ?>
                <div style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); position: relative;">
                    <a href="<?php echo SITEURL; ?>wishlist/remove.php?id=<?php echo $wishlist_id; ?>" style="position: absolute; top: 10px; right: 10px; color: #e74c3c; font-size: 20px; text-decoration: none;" title="Remove from Wishlist"><i class='bx bx-x-circle'></i></a>
                    
                    <div style="text-align: center; margin-bottom: 15px;">
                        <?php if ($image_name != ""): ?>
                            <img src="<?php echo SITEURL; ?>images/product/<?php echo $image_name; ?>" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">
                        <?php else: ?>
                            <div style="width: 150px; height: 150px; background: #eee; margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #888;">No Image</div>
                        <?php endif; ?>
                    </div>
                    
                    <h4 style="color: #155e58; text-align: center; margin-bottom: 5px;">
                        <a href="<?php echo SITEURL; ?>catalog/detail.php?id=<?php echo $product_id; ?>" style="color: inherit; text-decoration: none;"><?php echo htmlspecialchars($title); ?></a>
                    </h4>
                    
                    <p style="text-align: center; font-weight: bold; color: #e65100; font-size: 18px; margin-bottom: 15px;">৳<?php echo $price; ?></p>
                    
                    <a href="<?php echo SITEURL; ?>cart/add.php?product_id=<?php echo $product_id; ?>" style="display: block; text-align: center; padding: 10px; background: #155e58; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Add to Cart</a>
                </div>
        <?php
            }
        } else {
            echo "<div style='grid-column: 1 / -1; text-align: center; padding: 40px;'>";
            echo "<i class='bx bx-heart' style='font-size: 60px; color: #ccc; margin-bottom: 20px;'></i>";
            echo "<h3 style='color: #777;'>Your wishlist is empty</h3>";
            echo "<br><a href='" . SITEURL . "product.php' class='btn-auth' style='display:inline-block; width:auto; padding:10px 20px;'>Browse Products</a>";
            echo "</div>";
        }
        ?>
    </div>
</section>

<?php include('../partials-front/footer.php'); ?>
