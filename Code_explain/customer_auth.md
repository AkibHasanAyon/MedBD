# User Authentication & Customer Flow (MedBD)

This module explains the user registration, login, email verification, and profile management logic for customers in the MedBD system. It utilizes sessions, secure password hashing, and email integration.

---

## 1. `customer/register.php`
**Purpose:** Handles new customer registration, validates input, securely hashes the password, generates an OTP (One-Time Password) for email verification, and sends the welcome email.

### Key Logic & Flow:
1. **Input Validation:**
   The form data is collected via `POST` and sanitized using `mysqli_real_escape_string()` to prevent SQL injection. It verifies that passwords match and that the password is at least 6 characters long.
   
2. **Checking for Existing Users:**
   ```php
   $check_sql = "SELECT id FROM tbl_customer WHERE email='$email'";
   ```
   Ensures that an account with the provided email does not already exist.

3. **Password Security:**
   ```php
   $hashed_password = password_hash($password, PASSWORD_BCRYPT);
   ```
   Uses PHP's native bcrypt hashing algorithm to securely encrypt the password before storing it in the database.

4. **OTP Generation & Database Insertion:**
   A 6-digit random code is generated (`mt_rand`) and an expiry time (15 minutes from now) is set. The user is inserted with `is_verified=0`.

5. **Email Sending:**
   Includes `config/mailer.php` and calls the `sendMail()` function to send the 6-digit OTP to the user's email address. The user is then redirected to `verify-otp.php`.

---

## 2. `customer/verify-otp.php`
**Purpose:** Authenticates the 6-digit OTP sent to the user's email during registration or if they log in without being verified yet.

### Key Logic & Flow:
1. **Session Check:**
   It checks for `$_SESSION['verify-email']` to ensure only users who have just registered (or logged in while unverified) can access this page.

2. **OTP Verification:**
   ```php
   $sql = "SELECT id, full_name, email FROM tbl_customer WHERE email='$email' AND otp_code='$entered_otp' AND otp_expires_at > NOW()";
   ```
   This query checks three things simultaneously:
   - Does the email match?
   - Does the OTP match what they entered?
   - Is the current time (`NOW()`) before the `otp_expires_at` timestamp?

3. **Status Update & Login:**
   If the OTP is valid, `is_verified` is set to `1` and the OTP fields are set to `NULL` (so the code cannot be reused). The user is then programmatically logged in by setting `$_SESSION['customer_id']` and redirected to the homepage.

---

## 3. `customer/login.php`
**Purpose:** Authenticates returning customers and manages sessions for the shopping cart and checkout processes.

### Key Logic & Flow:
1. **Redirect Handling:**
   ```php
   $redirect_url = isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : '';
   ```
   Allows the system to remember where the user was before they were asked to log in (e.g., they clicked "Checkout" but weren't logged in, so they get sent to login, then redirected back to checkout).

2. **Authentication:**
   - Fetches the user record by email.
   - Uses `password_verify($password, $row['password'])` to compare the plaintext password input against the bcrypt hash in the database.

3. **Verification Check:**
   ```php
   if ($row['is_verified'] == 0) { ... redirect to resend-otp.php ... }
   ```
   If the user's credentials are correct but they never verified their email, they are not allowed to log in. They are redirected to get a new OTP.

4. **Session Creation:**
   If successful, user data is saved in `$_SESSION` and they are redirected appropriately.

---

## 4. `customer/profile.php`
**Purpose:** Acts as the dashboard for the customer to view/update their personal details, change their password, and view their recent order history.

### Key Logic & Flow:
1. **Authentication Check:**
   Includes `login-check.php` at the top. If a user is not logged in, they are immediately redirected to the login page.
   
2. **Profile Update (`update_profile`):**
   When the user submits the profile update form, it first checks if the new email they entered is already taken by *another* user (`id != $customer_id`). If not, it runs an `UPDATE` query.

3. **Password Change (`change_password`):**
   - Fetches the *current* password hash from the database.
   - Verifies the user typed their current password correctly (`password_verify`).
   - Validates the new password (length >= 6, matches confirm password).
   - Hashes the new password and updates the database.

4. **Order History Display:**
   ```php
   $order_sql = "SELECT * FROM tbl_order WHERE customer_id=$customer_id ORDER BY order_date DESC LIMIT 10";
   ```
   Fetches the user's latest 10 orders. It formats the output and dynamically applies CSS classes (`status-badge`) based on the order status (e.g., 'On Delivery', 'Delivered', 'Cancelled').
