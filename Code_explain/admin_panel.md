# Admin Panel Module (MedBD)

The Admin Panel (`admin/` directory) provides a secured backend interface for shop administrators to manage the catalog, view statistics, process orders, and handle low-stock alerts.

---

## 1. Dashboard Overview (`admin/index.php`)
**Purpose:** Serves as the homepage of the admin panel. It provides a high-level statistical overview of the business (total products, orders, customers, revenue) and alerts the admin to critical issues like low stock.

### Key Logic & Flow:
1. **Security / Authentication:**
   Includes `partials/menu.php` which typically contains an authentication check to ensure only logged-in administrators can access the page.
   
2. **Dashboard Statistics:**
   The page runs multiple aggregate queries to populate the statistical cards:
   - **Total Categories/Products:** `SELECT * FROM tbl_category` and `SELECT * FROM tbl_product`. Uses `mysqli_num_rows` to get the count.
   - **Total Orders/Customers:** Similar `SELECT *` queries on `tbl_order` and `tbl_customer`.
   - **Revenue Generated:** 
     ```php
     $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
     ```
     This calculates the total revenue *only* from successfully delivered orders.

3. **Low Stock Warning System:**
   - Queries `tbl_product WHERE stock_qty < 10` to find items running low on inventory.
   - If `count_stock > 0`, it dynamically renders a warning table (`<table class="tbl-full">`) listing the specific items and their remaining stock.
   - Provides a direct "Restock" button linking to `update-product.php` for quick resolution.

---

## 2. Product Management (`admin/manage-product.php`)
**Purpose:** Lists all products in the database and provides an interface to Add, Update, or Delete products from the catalog.

### Key Logic & Flow:
1. **Alerts & Messaging:**
   At the top, it checks the `$_SESSION` array for various messages (`add`, `delete`, `update`, `upload`) to display success or error notifications based on the admin's recent actions.
   
2. **Product Listing:**
   - Runs `SELECT * FROM tbl_product`.
   - Loops through the result set to render an HTML table (`tbl-full`).
   - Displays the product title, price, image (or a "No Image" placeholder if none exists).
   - Formats the "Featured" and "Active" status using colored badges (e.g., green for Yes, red for No) for quick visual scanning.
   
3. **Action Links:**
   - **Update:** `admin/update-product.php?id=$id`
   - **Delete:** `admin/delete-product.php?id=$id&image_name=$image_name`. Note how it explicitly passes the `image_name` in the URL so the deletion script can securely remove the physical image file from the server alongside the database record.

---

## 3. Order Management (`admin/manage-order.php`)
**Purpose:** Allows administrators to view all customer orders, check payment statuses, view uploaded medical prescriptions, and update order statuses (e.g., from 'Ordered' to 'Delivered').

### Key Logic & Flow:
1. **Order Listing (Descending Order):**
   ```php
   $sql="SELECT * FROM tbl_order ORDER BY id DESC";
   ```
   Ensures the newest orders appear at the very top of the table.

2. **Order Data Formatting:**
   - **Date:** Formats the raw database timestamp using `date("M j, Y g:i A", strtotime($order_date))` for better readability.
   - **Status Badges:** Uses an `if/else if` block to assign specific CSS styles to the order status:
     - Ordered (Grey)
     - On Delivery (Orange)
     - Delivered (Green)
     - Cancelled (Red)
   - **Payment Status:** Displays whether the payment method was Stripe or Cash on Delivery, and whether the status is Paid or Pending.

3. **Prescription Handling:**
   - Checks if `$prescription_image` is not empty.
   - If an image exists, it provides a hyperlink (`target="_blank"`) to securely view the uploaded prescription file in a new tab (`images/prescription/$prescription_image`).
   - If not, it displays "N/A".

4. **Action Link:**
   Provides an "Edit" button linking to `update-order.php?id=$id`, where the admin can change the status or update the payment status once the money is received.
