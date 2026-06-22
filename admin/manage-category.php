<?php include('partials/menu.php') ?>



    <div class="wrapper">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1 class="page-title" style="margin-bottom: 0;">Manage Categories</h1>
            <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary"><i class='bx bx-plus'></i> Add Category</a>
        </div>

        <?php
            if(isset($_SESSION['add'])) { echo $_SESSION['add']; unset($_SESSION['add']); }
            if(isset($_SESSION['upload'])) { echo $_SESSION['upload']; unset($_SESSION['upload']); }
            if(isset($_SESSION['remove'])) { echo $_SESSION['remove']; unset($_SESSION['remove']); }
            if(isset($_SESSION['delete'])) { echo $_SESSION['delete']; unset($_SESSION['delete']); }
            if(isset($_SESSION['no-category-found'])) { echo $_SESSION['no-category-found']; unset($_SESSION['no-category-found']); }
            if(isset($_SESSION['update'])) { echo $_SESSION['update']; unset($_SESSION['update']); }
            if(isset($_SESSION['failed-remove'])) { echo $_SESSION['failed-remove']; unset($_SESSION['failed-remove']); }
        ?>

        <div class="table-container">
            <table class="tbl-full">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="25%">Title</th>
                        <th width="20%">Image</th>
                        <th width="10%">Featured</th>
                        <th width="10%">Active</th>
                        <th width="30%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = 'SELECT * FROM tbl_category';
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    $sn = 1;
                    
                    if($count>0) {
                      while($row=mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>
                        <tr>
                            <td><?php echo $sn++;?></td>
                            <td style="font-weight: 500;"><?php echo $title;?></td>
                            <td>
                                <?php 
                                if($image_name!="") {
                                ?>
                                <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" width="50" style="border-radius:6px; border:1px solid #eee;">
                                <?php
                                } else {
                                  echo "<span style='color:#999; font-size:13px;'>No Image</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if($featured == 'Yes') echo "<span style='background:#e0f2fe; color:#0284c7; padding:2px 8px; border-radius:12px; font-size:12px; font-weight:500;'>Yes</span>"; else echo "No"; ?>
                            </td>
                            <td>
                                <?php if($active == 'Yes') echo "<span style='background:#ecfdf5; color:#059669; padding:2px 8px; border-radius:12px; font-size:12px; font-weight:500;'>Yes</span>"; else echo "<span style='background:#fef2f2; color:#dc2626; padding:2px 8px; border-radius:12px; font-size:12px; font-weight:500;'>No</span>"; ?>
                            </td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary"><i class='bx bx-edit'></i> Update</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"><i class='bx bx-trash'></i> Delete</a>
                            </td>
                        </tr>
                        <?php
                      }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; padding:30px; color:#666;'>No categories found.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include('partials/footer.php') ?>