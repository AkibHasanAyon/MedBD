# E-commerce Core Module (MedBD)

This module handles the fundamental functionality of the e-commerce store, including viewing the product catalog, adding items to the cart, processing orders, and handling payments (via Stripe or Cash on Delivery).

---

## 1. Catalog (`catalog/products.php` & `catalog/detail.php`)

### `catalog/products.php`
**Purpose:** Displays all active products in the store and provides a search bar.
- **Logic:** It queries `tbl_product WHERE active='Yes'`. For each product, it displays the image, title, price, and calculates the average rating by running an inner query on `tbl_review`. 
- **Actions:** Users can click "Add to Cart", "Buy Now", or click the product image to view its details.

### `catalog/detail.php`
**Purpose:** Displays the full details of a specific product, including description, reviews, and a "Requires Prescription" badge.
- **Logic:** 
  1. Retrieves the `id` from the URL via `$_GET['id']` and queries the database for that specific product.
  2. Runs a query to fetch all reviews (`tbl_review`) joined with the customer's name (`tbl_customer`), calculates the average rating, and displays the reviews in a list.
  3. Displays a form allowing logged-in customers to submit their own 1-5 star review.
  4. Provides action buttons: Add to Cart, Buy Now, and Add to Wishlist.

---

## 2. Shopping Cart (`cart/add.php` & `cart/index.php`)

### `cart/add.php`
**Purpose:** Adds a product to the user's shopping cart in the database.
- **Authentication Check:** Forces the user to log in if they aren't already.
- **Cart Logic:**
  - Queries `tbl_cart` to see if the customer already has this `product_id` in their cart.
  - **If YES:** It runs an `UPDATE` query to increment the `qty` (quantity) by 1.
  - **If NO:** It runs an `INSERT` query to add the product to the cart with a quantity of 1.
- **Redirect:** Uses `$_SERVER['HTTP_REFERER']` to seamlessly send the user back to the page they were just on.

### `cart/index.php` (Overview)
**Purpose:** Displays the contents of the user's cart.
- It queries `tbl_cart` joined with `tbl_product` to get the product details and quantities.
- Calculates the subtotal for each item and the grand total.
- Allows the user to update quantities or remove items, routing them to the checkout page when ready.

---

## 3. Checkout & Order Processing (`checkout/process.php`)

### `checkout/process.php`
**Purpose:** The core engine that processes the final order, handles prescription uploads, checks stock, and saves the order to the database.
- **Data Collection:** Collects shipping details (name, email, address) from the `$_POST` array.
- **Prescription Upload:** If a prescription file is uploaded (required for certain meds), it renames the file securely and moves it to `images/prescription/`.
- **Stock Validation:** 
  - Whether checking out a single item or the whole cart, it verifies that the requested `qty` does not exceed the available `stock_qty` in the database. If it does, it aborts the order and shows an error.
- **Order Insertion:** 
  - Loops through each item and inserts a record into `tbl_order`. 
  - Simultaneously runs an `UPDATE` query on `tbl_product` to decrement the stock by the purchased amount (`$new_stock = $item['stock_qty'] - $qty`).
- **Cart Cleanup:** If the user checked out from their cart (rather than "Buy Now"), it deletes their items from `tbl_cart`.
- **Payment Routing:**
  - If **Cash on Delivery**, it sends an order confirmation email and redirects to the order history page.
  - If **Stripe**, it redirects the user to `stripe.php`.

---

## 4. Payment Gateway (`checkout/stripe.php`)

### `checkout/stripe.php`
**Purpose:** Integrates with the Stripe API to handle credit card payments securely.
- **API Integration:** Instead of using a bulky PHP library, it uses **cURL** to send an HTTP request directly to Stripe's REST API (`https://api.stripe.com/v1/checkout/sessions`).
- **Payload Data:** It passes the `STRIPE_SECRET_KEY` for authentication and builds an array containing the order details (currency: `bdt`, total amount, and success/cancel URLs).
- **Session Redirection:** If Stripe successfully creates a checkout session (HTTP 200), the script captures the `url` from the JSON response and redirects the user to Stripe's secure hosted payment page.
