<?php include('partials/menu.php') ?>
<!-- main -->
    <div class="wrapper">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1 class="page-title" style="margin-bottom: 0;">Manage Admins</h1>
            <a href="add-admin.php" class="btn-primary"><i class='bx bx-user-plus'></i> Add Admin</a>
        </div>

        <?php 
           if(isset($_SESSION['add'])) { echo $_SESSION['add']; unset($_SESSION['add']); }
           if(isset($_SESSION['delete'])) { echo $_SESSION['delete']; unset($_SESSION['delete']); }
           if(isset($_SESSION['update'])) { echo $_SESSION['update']; unset($_SESSION['update']); }
           if(isset($_SESSION['user-not-found'])) { echo $_SESSION['user-not-found']; unset($_SESSION['user-not-found']); }
           if(isset($_SESSION['pwd-not-match'])) { echo $_SESSION['pwd-not-match']; unset($_SESSION['pwd-not-match']); }
           if(isset($_SESSION['change-pwd'])) { echo $_SESSION['change-pwd']; unset($_SESSION['change-pwd']); }
        ?>

        <div class="table-container">
            <table class="tbl-full">
                <thead>
                    <tr>
                        <th width="10%">S.N</th>
                        <th width="30%">Full Name</th>
                        <th width="20%">User Name</th>
                        <th width="40%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                  $sql="SELECT * FROM tbl_admin";
                  $res=mysqli_query($conn,$sql);

                  if($res==TRUE) {
                    $count=mysqli_num_rows($res);
                    $sn=1;
                    if($count>0) {
                      while($rows=mysqli_fetch_assoc($res)) {
                        $id=$rows['id'];
                        $full_name=$rows['full_name'];
                        $username=$rows['username'];
                ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td style="font-weight: 500;"><?php echo $full_name; ?></td>
                            <td style="color: #666;">@<?php echo $username; ?></td>
                            <td style="display: flex; gap: 8px;">
                                <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary" style="font-size: 13px; padding: 6px 12px;"><i class='bx bx-key'></i> Password</a>
                                <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary" style="font-size: 13px; padding: 6px 12px;"><i class='bx bx-edit'></i> Edit</a>
                                <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger" style="font-size: 13px; padding: 6px 12px;"><i class='bx bx-trash'></i> Delete</a>
                            </td>
                        </tr>
                <?php 
                      }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center; padding:30px; color:#666;'>No Admins Found.</td></tr>";
                    }
                  }
               ?>
               </tbody>
            </table>
        </div>
    </div>
<!-- footer -->

<?php include('partials/footer.php') ?>