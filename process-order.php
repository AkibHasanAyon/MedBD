<?php
include('config/constants.php');

if (!isset($_SESSION['customer_id'])) {
    header('location:' . SITEURL . 'customer/login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $customer_id = (int)$_SESSION['customer_id'];
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    
    $is_cart = (int)$_POST['is_cart'];
    $order_date = date("Y-m-d H:i:s");
    $status = "Ordered";
    $payment_status = "Pending";
    
    // Handle prescription upload
    $prescription_name = "";
    if (isset($_FILES['prescription']['name']) && $_FILES['prescription']['name'] != "") {
        $name_parts = explode('.', $_FILES['prescription']['name']);
        $ext = end($name_parts);
        $prescription_name = "Prescription_" . rand(0000, 9999) . "." . $ext;
        $src = $_FILES['prescription']['tmp_name'];
        $dst = "images/prescription/" . $prescription_name;
        
        // Ensure directory exists
        if (!is_dir("images/prescription")) {
            mkdir("images/prescription", 0777, true);
        }
        
        $upload = move_uploaded_file($src, $dst);
        if ($upload == false) {
            $_SESSION['order-error'] = "<div class='error'>Failed to upload prescription. Please try again.</div>";
            header('location:' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    $items = [];
    $total_amount = 0;

    if ($is_cart) {
        $sql = "SELECT c.qty, p.id as product_id, p.title, p.price FROM tbl_cart c JOIN tbl_product p ON c.product_id = p.id WHERE c.customer_id=$customer_id";
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $items[] = $row;
            $total_amount += ($row['price'] * $row['qty']);
        }
    } else {
        $product_id = (int)$_POST['product_id'];
        $sql = "SELECT id as product_id, title, price FROM tbl_product WHERE id=$product_id";
        $res = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($res)) {
            $row['qty'] = 1;
            $items[] = $row;
            $total_amount = $row['price'];
        }
    }

    if (empty($items)) {
        header('location:' . SITEURL);
        exit();
    }

    // Insert orders
    $order_ids = [];
    foreach ($items as $item) {
        $product = mysqli_real_escape_string($conn, $item['title']);
        $product_id = (int)$item['product_id'];
        $price = $item['price'];
        $qty = $item['qty'];
        $total = $price * $qty;
        
        $insert_sql = "INSERT INTO tbl_order SET
            customer_id=$customer_id,
            product_id=$product_id,
            product='$product',
            price=$price,
            qty=$qty,
            total=$total,
            order_date='$order_date',
            status='$status',
            payment_method='$payment_method',
            payment_status='$payment_status',
            prescription_image='$prescription_name',
            customer_name='$customer_name',
            customer_contact='$customer_contact',
            customer_email='$customer_email',
            customer_address='$customer_address'
        ";
        
        if (mysqli_query($conn, $insert_sql)) {
            $order_ids[] = mysqli_insert_id($conn);
        } else {
            error_log("Order Insert Failed: " . mysqli_error($conn));
        }
    }

    if (empty($order_ids)) {
        $_SESSION['order-error'] = "<div class='error'>Failed to process order.</div>";
        header('location:' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // If cart checkout, empty the cart
    if ($is_cart) {
        mysqli_query($conn, "DELETE FROM tbl_cart WHERE customer_id=$customer_id");
    }

    // Process Payment
    if ($payment_method == "Stripe") {
        // Redirect to Stripe Checkout page
        $order_ids_str = implode(',', $order_ids);
        header('location:' . SITEURL . 'stripe-checkout.php?order_ids=' . $order_ids_str . '&amount=' . ($total_amount * 100));
        exit();
    } else {
        // Cash on delivery
        // Send email
        include('send_order_email.php');
        sendOrderConfirmationEmail($customer_email, $customer_name, $order_ids);

        $_SESSION['success'] = "Order Placed Successfully! Your order will be delivered soon.";
        header('location:' . SITEURL . 'customer/my-orders.php');
        exit();
    }

} else {
    header('location:' . SITEURL);
}
?>
