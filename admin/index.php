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
            //sql query
               $sql3="SELECT * FROM tbl_order";
                //execute query
                $res3=mysqli_query($conn,$sql3);
                //count rows
                $count3=mysqli_num_rows($res3);

             ?>
            <h1><?php echo $count3; ?></h1>
            <br>
            Total Orders
        </div>
        <div class="col-4 text-center">
            <?php 
            //Aggregate function in sql
               $sql4="SELECT SUM(total) AS Total FROM tbl_order 
            --    WHERE status='Delivered'
               ";
                //execute query
                $res4=mysqli_query($conn,$sql4);
                //Get the value
                $row4=mysqli_fetch_assoc($res4);

                //Get the total revenue
                $total_revenue=$row4['Total'];

             ?>
            <h1>৳<?php echo $total_revenue; ?></h1>
            <br>
            Revenue Generated
        </div>
        <!-- <div class="clearfix"></div> -->
    </div>
</div>
<!-- footer -->


<?php include('partials/footer.php') ?>