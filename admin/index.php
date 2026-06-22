<?php include('partials/menu.php') ?>
<!-- main -->
<div class="main-content">

    <div class="wrapper wrapper2">
        <h1 style="padding-top: 50px">DASHBOARD</h1>
        <br><br><br><br>

        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        ?>
        <br><br>
        <div class="col-4 text-center">
            <?php 
            //sql query
               $sql="SELECT * FROM tbl_category";
                //execute query
                $res=mysqli_query($conn,$sql);
                //count rows
                $count=mysqli_num_rows($res);

             ?>
            <h1><?php echo $count; ?></h1>
            <br>
            Category
        </div>
        <div class="col-4 text-center">
            <?php 
            //sql query
               $sql2="SELECT * FROM tbl_product";
                //execute query
                $res2=mysqli_query($conn,$sql2);
                //count rows
                $count2=mysqli_num_rows($res2);

             ?>
            <h1><?php echo $count2; ?></h1>
            <br>
            Products
        </div>
        <div class="col-4 text-center">
            
            <?php 
                //Sql Query 
                $sql3 = "SELECT * FROM tbl_order";
                //Execute Query
                $res3 = mysqli_query($conn, $sql3);
                //Count Rows
                $count3 = mysqli_num_rows($res3);
            ?>

            <h1><?php echo $count3; ?></h1>
            <br />
            Total Orders
        </div>

        <div class="col-4 text-center">
            
            <?php 
                //Sql Query 
                $sql_cust = "SELECT * FROM tbl_customer";
                //Execute Query
                $res_cust = mysqli_query($conn, $sql_cust);
                //Count Rows
                $count_cust = mysqli_num_rows($res_cust);
            ?>

            <h1><?php echo $count_cust; ?></h1>
            <br />
            Total Customers
        </div>

        <div class="col-4 text-center">
            
            <?php 
                //Creat SQL Query to Get Total Revenue Generated
                //Aggregate Function in SQL
                $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                //Execute the Query
                $res4 = mysqli_query($conn, $sql4);

                //Get the VAlue
                $row4 = mysqli_fetch_assoc($res4);
                
                //GEt the Total REvenue
                $total_revenue = $row4['Total'] ? $row4['Total'] : 0;

            ?>

            <h1>৳<?php echo $total_revenue; ?></h1>
            <br />
            Revenue Generated
        </div>
        <!-- <div class="clearfix"></div> -->
    </div>
</div>
<!-- footer -->


<?php include('partials/footer.php') ?>