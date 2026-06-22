<?php include('partials-front/menu.php'); ?>

<?php
if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $sql = "SELECT * FROM tbl_product WHERE id=$product_id AND active='Yes'";
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) == 1) {
        $product = mysqli_fetch_assoc($res);
    } else {
        header('location:' . SITEURL . 'product.php');
        exit();
    }
} else {
    header('location:' . SITEURL . 'product.php');
    exit();
}

// Get reviews
$rev_sql = "SELECT r.*, c.full_name FROM tbl_review r JOIN tbl_customer c ON r.customer_id = c.id WHERE r.product_id=$product_id ORDER BY r.created_at DESC";
$rev_res = mysqli_query($conn, $rev_sql);
$rev_count = mysqli_num_rows($rev_res);

$avg_rating = 0;
if ($rev_count > 0) {
    $sum_sql = "SELECT SUM(rating) as total_rating FROM tbl_review WHERE product_id=$product_id";
    $sum_res = mysqli_query($conn, $sum_sql);
    $sum_row = mysqli_fetch_assoc($sum_res);
    $avg_rating = round($sum_row['total_rating'] / $rev_count, 1);
}
?>

<section class="product-detail-section" style="padding: 40px 20px; max-width: 1000px; margin: 0 auto; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-radius: 12px; margin-top: 40px; margin-bottom: 40px;">
    
    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 40px; margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 40px;">
        <!-- Product Image -->
        <div>
            <?php if ($product['image_name'] != ""): ?>
                <img src="<?php echo SITEURL; ?>images/product/<?php echo $product['image_name']; ?>" style="width: 100%; border-radius: 8px;">
            <?php else: ?>
                <div style="width: 100%; height: 300px; background: #eee; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #888;">Image Not Available</div>
            <?php endif; ?>
        </div>

        <!-- Product Details -->
        <div>
            <h2 style="color: #155e58; font-size: 32px; margin-bottom: 10px;"><?php echo htmlspecialchars($product['title']); ?></h2>
            
            <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <span style="color: #ffb300; font-size: 20px;">
                    <?php 
                        for($i=1; $i<=5; $i++) {
                            if ($i <= round($avg_rating)) echo "★";
                            else echo "☆";
                        }
                    ?>
                </span>
                <span style="color: #666; font-size: 14px;">(<?php echo $avg_rating; ?> / 5) - <?php echo $rev_count; ?> reviews</span>
            </div>

            <p style="font-size: 28px; font-weight: bold; color: #e65100; margin-bottom: 20px;">৳<?php echo $product['price']; ?></p>
            
            <div style="color: #555; line-height: 1.6; margin-bottom: 30px;">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </div>

            <?php if ($product['requires_prescription'] == 'Yes'): ?>
                <div style="background: #ffebee; color: #c62828; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; display: inline-block;">
                    <i class='bx bx-plus-medical'></i> Prescription Required
                </div>
                <br>
            <?php endif; ?>

            <div style="display: flex; gap: 15px;">
                <a href="<?php echo SITEURL; ?>add-to-cart.php?product_id=<?php echo $product_id; ?>" style="padding: 15px 30px; background: #155e58; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;">Add to Cart</a>
                <a href="<?php echo SITEURL; ?>order.php?product_id=<?php echo $product_id; ?>" style="padding: 15px 30px; background: #15c293; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;">Buy Now</a>
                <a href="<?php echo SITEURL; ?>add-to-wishlist.php?product_id=<?php echo $product_id; ?>" style="padding: 15px 20px; background: #fdfdfd; color: #e74c3c; border: 2px solid #e74c3c; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;" title="Add to Wishlist"><i class='bx bxs-heart'></i></a>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <h3 style="color: #333; margin-bottom: 20px;">Customer Reviews</h3>

        <?php
        if (isset($_SESSION['review-msg'])) {
            echo $_SESSION['review-msg'];
            unset($_SESSION['review-msg']);
        }
        ?>

        <!-- Write Review Form -->
        <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
            <h4 style="margin-bottom: 15px;">Write a Review</h4>
            <?php if (isset($_SESSION['customer_id'])): ?>
                <form action="<?php echo SITEURL; ?>add-review.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Rating</label>
                        <select name="rating" required style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Good</option>
                            <option value="3">3 - Average</option>
                            <option value="2">2 - Poor</option>
                            <option value="1">1 - Terrible</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Your Review</label>
                        <textarea name="review_text" rows="4" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;"></textarea>
                    </div>

                    <input type="submit" name="submit" value="Submit Review" style="padding: 10px 20px; background: #155e58; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                </form>
            <?php else: ?>
                <p>Please <a href="<?php echo SITEURL; ?>customer/login.php" style="color: #155e58; font-weight: bold;">login</a> to write a review.</p>
            <?php endif; ?>
        </div>

        <!-- Review List -->
        <?php if ($rev_count > 0): ?>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <?php while ($rev = mysqli_fetch_assoc($rev_res)): ?>
                    <div style="border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <strong style="color: #155e58;"><?php echo htmlspecialchars($rev['full_name']); ?></strong>
                            <span style="color: #ffb300;">
                                <?php 
                                    for($i=1; $i<=5; $i++) {
                                        if ($i <= $rev['rating']) echo "★";
                                        else echo "☆";
                                    }
                                ?>
                            </span>
                        </div>
                        <div style="color: #888; font-size: 12px; margin-bottom: 10px;"><?php echo date('d M Y', strtotime($rev['created_at'])); ?></div>
                        <p style="color: #444; margin: 0; line-height: 1.5;"><?php echo nl2br(htmlspecialchars($rev['review_text'])); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p style="color: #888; text-align: center; padding: 20px;">No reviews yet. Be the first to review this product!</p>
        <?php endif; ?>

    </div>

</section>

<?php include('partials-front/footer.php'); ?>
