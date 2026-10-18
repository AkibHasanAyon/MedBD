# 💊 MedBD — Online Medical E-Commerce Platform

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00758F?style=for-the-badge&logo=mysql&logoColor=white)
![Stripe](https://img.shields.io/badge/Stripe-API-635BFF?style=for-the-badge&logo=stripe&logoColor=white)
![Status](https://img.shields.io/badge/Status-Production--Ready-success?style=for-the-badge)

**MedBD** is a full-featured medical e-commerce platform designed to enable customers to browse, search, and order pharmaceuticals, diagnostic health devices, baby care essentials, vitamins, and healthcare supplies.

The project incorporates a domain-driven architectural refactoring, secure customer authentication with email OTP verification, automated order invoicing, Stripe card checkout, and an administrative inventory control dashboard.

---

## 🌟 Key Features

### 👤 Customer Experience
* **Secure Authentication**: Customer registration and login using bcrypt password hashing. Includes **Email OTP Verification** (via PHPMailer) to prevent dummy registrations and a secure password reset workflow.
* **Smart Catalog & Live Search**: Category filtering, instant keyword search, and live product autosuggest.
* **Cart & Wishlist**: Persistent cart and wishlist tracking tied to the customer's account session.
* **Stripe Checkout**: Integrated card payment processing via Stripe API with stock availability validation prior to payment capture.
* **Automated Email Notifications**: HTML invoices and order confirmation receipts dispatched instantly via SMTP.
* **Verified Purchase Reviews**: Only authenticated customers who have received a completed order (`status = 'Delivered'`) are permitted to submit product reviews and star ratings.
* **Order Tracking (`my-orders.php`)**: Full real-time delivery status tracking (`Ordered` $\to$ `On Delivery` $\to$ `Delivered` $\to$ `Cancelled`).

### 🛠️ Administrative Operations (`admin/`)
* **Catalog Management**: Add, update, feature, or deactivate product categories and individual products.
* **Inventory & Low-Stock Alerts**: Live stock counter that deducts quantities upon confirmed checkout and surfaces low-inventory warnings.
* **Order Processing**: View incoming order queues, inspect recipient delivery information, and update dispatch milestones.
* **Role Management**: Add, manage, and update sub-administrator credentials.

---

## 🏗️ Domain-Driven Project Architecture

```text
MedBD/
├── admin/               # Admin dashboard and catalog/order management
├── cart/                # Shopping cart UI, add, update, and remove logic
├── catalog/             # Product listings, categories, search, verified reviews
├── checkout/            # Checkout flow, Stripe processing, and order emails
├── config/              # Core configurations (DB connection, Mailer helper)
├── customer/            # Customer auth (Login, Register, OTP verification, Profile)
├── css/                 # Global styling and specific component stylesheets
├── images/              # Static assets (logos, products, categories, banner)
├── pages/               # Informational pages (Contact Us)
├── partials-front/      # Reusable UI partials (Header, Navigation Menu, Footer)
├── PHPMailer/           # SMTP email mailing library
├── sql/                 # Database schema dump (medbd.sql)
├── wishlist/            # Customer wishlist UI and handlers
└── Code_explain/        # In-depth architectural documentation
    ├── admin_panel.md
    ├── config_and_index.md
    ├── customer_auth.md
    └── ecommerce_core.md
```

---

## 🛠️ Technology Stack

* **Frontend**: HTML5, Vanilla CSS3, BoxIcons for UI iconography.
* **Backend**: PHP 8.0+ (Procedural modular architecture).
* **Database**: MySQL (Relational schema with normalized tables).
* **Payment Gateway**: Stripe API (Stripe Checkout / Payment Intents).
* **Email System**: PHPMailer via SMTP.

---

## ⚙️ Installation & Setup

### Prerequisites
* Local PHP & MySQL server (XAMPP, WAMP, or LAMP).
* PHP **8.0** or later.
* MySQL / MariaDB.

### Step 1: Clone or Copy Project
Place the `MedBD` directory in your web server's public document root:
```text
C:\xampp\htdocs\MedBD\
```

### Step 2: Database Initialization
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Create a database named `medbd`.
3. Import the database dump located at:
   ```text
   MedBD/sql/medbd.sql
   ```

### Step 3: Configure Environment Credentials
Open [`config/constants.php`](file:///C:/Users/HP/Downloads/Ayon/MedBD/config/constants.php) and set your local credentials:

```php
// Database Configuration
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'medbd');

// Base Site URL (must end with a trailing slash)
define('SITEURL', 'http://localhost/MedBD/');

// Stripe API Credentials (test keys)
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_...');
define('STRIPE_SECRET_KEY', 'sk_test_...');

// SMTP Email Credentials (for OTP and Invoices)
define('SMTP_USERNAME', 'your_email@gmail.com');
define('SMTP_PASSWORD', 'your_app_password');
```

### Step 4: Run the Application
* **Storefront**: Navigate to `http://localhost/MedBD/`
* **Admin Dashboard**: Navigate to `http://localhost/MedBD/admin/`

---

## 📚 Technical Documentation
Detailed architectural breakdowns are available in the [`Code_explain/`](file:///C:/Users/HP/Downloads/Ayon/MedBD/Code_explain/) directory:
* [`customer_auth.md`](file:///C:/Users/HP/Downloads/Ayon/MedBD/Code_explain/customer_auth.md) — Authentication, OTP lifecycle, and password resets.
* [`ecommerce_core.md`](file:///C:/Users/HP/Downloads/Ayon/MedBD/Code_explain/ecommerce_core.md) — Cart calculations, checkout, and inventory decrement logic.
* [`admin_panel.md`](file:///C:/Users/HP/Downloads/Ayon/MedBD/Code_explain/admin_panel.md) — Administrative workflows and role-based access.
* [`config_and_index.md`](file:///C:/Users/HP/Downloads/Ayon/MedBD/Code_explain/config_and_index.md) — Core configurations and entry routing.

