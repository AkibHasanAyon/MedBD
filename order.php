<?php include 'partials-front/menu.php';?>
<?php

//check whether product is  set or not
if (isset($_GET['product_id'])) {
    //Get the product id and details of the selected
    $product_id = $_GET['product_id'];

    //Get the details of the selected product
    $sql = "SELECT * FROM tbl_product WHERE id=$product_id";
    //execute the query
    $res = mysqli_query($conn, $sql);
    //Count the rows
    $count = mysqli_num_rows($res);
    //check the data is available or not
    if ($count == 1) {
        //we have data
        //Get the data from Database
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];

    } else {
        //product not available
        //Redirect to home page
        header('location:' . SITEURL);
    }
} else {
    //redirect to homepage
    header('location:' . SITEURL);
}

?>

<!-- product sEARCH Section Starts Here -->
<section class="product-search">
    <div class="container">

        <div class="center">
            <h2 class="b-order1 text-white">Fill this form to confirm your order</h2>

        </div>
        <form action="" method="POST" class="order b-order">
            <fieldset>
                <legend class="b-order2">Selected product</legend>

                <div class="product-menu-img">
                    <?php

//check whether the image is available or not
if ($image_name == "") {
    //image not avialble
    echo "<div class='error'>Image Not Available.</div>";
} else {
    //image Available
    ?>

                    <img src="<?php echo SITEURL; ?>images/product/<?php echo $image_name; ?>" alt="medicine"
                        class="img-responsive img-curve">
                    <?php

}

?>

                </div>

                <div class="product-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="product" value="<?php echo $title; ?>">
                    <p class="product-price"><?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="your full name" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="your phone number" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="your email address" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="your address" class="input-responsive"
                    required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>
        <?php
//Check whether submit button is clicked or not
if (isset($_POST['submit'])) {
    //Get all the details from the form

    $product_id = $_GET['product_id'];
    $product = $_POST['product'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $total = $price * $qty; //total=price*qty
    // $order_date=date();
    $order_date = date("Y-m-d h:i:sa"); //order date
    $status = "Ordered"; //ordered ,on delivery ,Delivered,Cancelation
    $customer_name = $_POST['full-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];

    //Save the order in datbase
    //Create SQL to save the data
    $product = str_replace("'","\'",$product);
    $customer_address = str_replace("'","\'",$customer_address);

    $sql2 = "INSERT INTO tbl_order SET
                  product_id = $product_id,
                  product='$product',
                  price=$price,
                  qty=$qty,
                  total=$total,
                  order_date='$order_date',
                  status='$status',
                  customer_name='$customer_name',
                  customer_contact='$customer_contact',
                  customer_email='$customer_email',
                  customer_address='$customer_address'

                ";
    //execute the query
    $res2 = mysqli_query($conn, $sql2);
    //Check whether query executed successfully or not
    if ($res2 == true) {
        //query executed and order saved
        $_SESSION['order'] = "<div class='success text-center'>Product ordered successfully </div>";
        header('location:' . SITEURL);
    } else {
        //Failed to Save Order
        $_SESSION['order'] = "<div class='error text-center'>Failed to order product </div>";
        header('location:' . SITEURL);
    }
}
?>
    </div>
</section>
<!-- Product sEARCH Section Ends Here -->

<?php include 'partials-front/footer.php';?>