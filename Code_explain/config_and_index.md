# Configuration & Global Files (MedBD)

This document explains the core files that initialize the MedBD application, manage database connectivity, configuration settings, and serve as the main entry point for users.

---

## 1. `config/constants.php`
**Purpose:** This is the most crucial configuration file in the project. It sets up application-wide constants, loads environment variables, starts the session, and establishes the database connection. It is typically included at the top of almost every other PHP file.

### Key Logic & Flow:
1. **Session Management:**
   ```php
   session_start();
   ```
   Starts a new or resumes an existing PHP session, which is necessary for tracking logged-in users (both customers and admins) and cart states.
   
2. **Global Constants:**
   ```php
   define('SITEURL','http://localhost/MedBD/');
   define('LOCALHOST','localhost');
   ...
   ```
   Defines the base URL (`SITEURL`) used for creating absolute links to CSS, images, and other pages, ensuring links don't break if the folder structure changes. It also defines database credentials.

3. **Environment Variables (.env Loading):**
   ```php
   $envPath = __DIR__ . '/../.env';
   if (file_exists($envPath)) {
       $env = parse_ini_file($envPath);
       ...
   }
   ```
   Parses the `.env` file from the root directory to securely load sensitive credentials (like Stripe API keys for payments and SMTP credentials for emails) without hardcoding them into the repository.

4. **Database Connection:**
   ```php
   $conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(...);
   $db_select=mysqli_select_db($conn,DB_NAME) or die(...);
   ```
   Uses the `mysqli` extension to connect to the MySQL database. If it fails, script execution stops (`die()`).

---

## 2. `config/mailer.php`
**Purpose:** A utility file that encapsulates the logic for sending emails via SMTP using the `PHPMailer` library. 

### Key Logic & Flow:
1. **Importing PHPMailer:**
   It requires the core PHPMailer classes (Exception, PHPMailer, SMTP) from the `PHPMailer/src` directory.
   
2. **The `sendMail()` Function:**
   ```php
   function sendMail($to_email, $to_name, $subject, $body, $altBody = '') { ... }
   ```
   This reusable function takes the recipient details, subject, and body (HTML or plain text).

3. **SMTP Configuration:**
   It configures the SMTP host (`smtp.gmail.com`), uses STARTTLS encryption, port `587`, and authenticates using the `SMTP_USERNAME` and `SMTP_PASSWORD` constants (which were loaded from the `.env` file via `constants.php`).

4. **Error Handling:**
   Wrapped in a `try-catch` block. If the email fails to send, it silently logs the error to the PHP error log rather than crashing the user interface, returning `false` so the calling script knows it failed.

---

## 3. `index.php`
**Purpose:** This is the main landing page of the application (Homepage). It displays a search bar, featured categories, and a list of exclusive products to entice the user to shop.

### Key Logic & Flow:
1. **Header Inclusion:**
   ```php
   <?php include('partials-front/menu.php'); ?>
   ```
   Includes the frontend navigation bar and header. (Note: `menu.php` internally includes `config/constants.php` to connect to the database and start the session).

2. **Search Section (Hero):**
   A form that sends a `POST` request to `product-search.php` passing the user's search string.

3. **Featured Categories Rendering:**
   ```php
   $sql="SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes'";
   ```
   Queries the database for categories that are marked as active and featured. A `while` loop iterates over the result set, generating HTML cards for each category. Clicking a category links to `category-product.php?category_id=X`.

4. **Exclusive Products Rendering:**
   ```php
   $sql2="SELECT * FROM tbl_product WHERE active='Yes' AND featured='Yes' LIMIT 6";
   ```
   Similar to categories, it fetches the top 6 featured and active products.
   - For each product, it displays the image, price, and description.
   - It runs an internal query on `tbl_review` to calculate and display the **average star rating** for each product using a `SELECT AVG(rating) ...` query.
   - It provides an "Add to Cart" button (linking to `cart/add.php?product_id=X`) and a "Buy Now" button (linking directly to the checkout).

5. **Footer Inclusion:**
   ```php
   <?php include('partials-front/footer.php'); ?>
   ```
   Includes the footer layout to close the HTML document.
