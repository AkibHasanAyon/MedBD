<?php include('partials/menu.php') ?>
<!-- main -->
    <div class="wrapper">
        <h1 class="page-title">Dashboard Overview</h1>

        <?php
            if(isset($_SESSION['login'])){
                echo "<div class='success'>" . $_SESSION['login'] . "</div>";
                unset($_SESSION['login']);
            }
        ?>
        
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class='bx bx-category'></i></div>
                <div class="stat-details">
                    <?php 
                       $sql="SELECT * FROM tbl_category";
                       $res=mysqli_query($conn,$sql);
                       $count=mysqli_num_rows($res);
                    ?>
                    <h1><?php echo $count; ?></h1>
                    <span>Total Categories</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class='bx bx-package'></i></div>
                <div class="stat-details">
                    <?php 
                       $sql2="SELECT * FROM tbl_product";
                       $res2=mysqli_query($conn,$sql2);
                       $count2=mysqli_num_rows($res2);
                    ?>
                    <h1><?php echo $count2; ?></h1>
                    <span>Total Products</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class='bx bx-cart'></i></div>
                <div class="stat-details">
                    <?php 
                        $sql3 = "SELECT * FROM tbl_order";
                        $res3 = mysqli_query($conn, $sql3);
                        $count3 = mysqli_num_rows($res3);
                    ?>
                    <h1><?php echo $count3; ?></h1>
                    <span>Total Orders</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class='bx bx-group'></i></div>
                <div class="stat-details">
                    <?php 
                        $sql_cust = "SELECT * FROM tbl_customer";
                        $res_cust = mysqli_query($conn, $sql_cust);
                        $count_cust = mysqli_num_rows($res_cust);
                    ?>
                    <h1><?php echo $count_cust; ?></h1>
                    <span>Total Customers</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class='bx bx-money'></i></div>
                <div class="stat-details">
                    <?php 
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
                        $res4 = mysqli_query($conn, $sql4);
                        $row4 = mysqli_fetch_assoc($res4);
                        $total_revenue = $row4['Total'] ? $row4['Total'] : 0;
                    ?>
                    <h1>৳<?php echo number_format($total_revenue, 2); ?></h1>
                    <span>Revenue Generated</span>
                </div>
            </div>

            <div class="stat-card" style="border-left: 4px solid #ef4444;">
                <div class="stat-icon" style="background-color: #fee2e2; color: #ef4444;"><i class='bx bx-alarm-exclamation'></i></div>
                <div class="stat-details">
                    <?php 
                        $sql_stock = "SELECT * FROM tbl_product WHERE stock_qty < 10";
                        $res_stock = mysqli_query($conn, $sql_stock);
                        $count_stock = mysqli_num_rows($res_stock);
                    ?>
                    <h1 style="color: #ef4444;"><?php echo $count_stock; ?></h1>
                    <span>Low Stock Items</span>
                </div>
            </div>
        </div>

        <?php if($count_stock > 0): ?>
        <br>
        <div class="table-container">
            <h2 style="margin-bottom: 20px; color: #ef4444; display: flex; align-items: center; gap: 8px;">
                <i class='bx bx-error-circle'></i> Low Stock Warning
            </h2>
            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Product</th>
                    <th>Remaining Stock</th>
                    <th>Action</th>
                </tr>
                <?php
                $sn = 1;
                while($row_stock = mysqli_fetch_assoc($res_stock)) {
                    $p_id = $row_stock['id'];
                    $p_title = $row_stock['title'];
                    $p_stock = $row_stock['stock_qty'];
                ?>
                <tr>
                    <td><?php echo $sn++; ?>.</td>
                    <td><?php echo $p_title; ?></td>
                    <td style="color: #ef4444; font-weight: bold;"><?php echo $p_stock; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/update-product.php?id=<?php echo $p_id; ?>" class="btn-secondary">Restock</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php endif; ?>

    </div>
<!-- footer -->


<?php include('partials/footer.php') ?>