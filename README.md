# MedBD — Online Medical E-Commerce Platform

![MedBD Logo](images/MedBdLogo.png)

**MedBD** is a full-stack, web-based medical e-commerce platform designed to allow customers to seamlessly browse, search, and order medicines, healthcare devices, baby care items, vitamins, and personal care products. The platform includes a comprehensive, secure admin dashboard to manage the catalog, inventory, and orders.

The goal of this project is to provide a complete, secure, and responsive online pharmacy system that mirrors real-world e-commerce platforms.

## 🚀 Features

### Customer Experience
* **Secure Authentication**: Registration and Login with bcrypt password hashing. Includes **Email OTP Verification** to ensure genuine accounts, alongside a secure Password Reset flow.
* **Product Catalog**: Browse products by category or search by keyword.
* **Shopping Cart & Wishlist**: Persistent cart and wishlist tracking tied to the user's account.
* **Checkout Process**: Secure checkout flow with **Stripe API** integration for payments. Features stock validation to prevent ordering out-of-stock items.
* **Order Tracking**: Customers can view their past orders and track current delivery statuses.
* **Email Notifications**: Automated order confirmation emails sent via **PHPMailer**.
* **Verified Reviews**: Customers can only leave reviews on products they have successfully purchased and received (status marked as "Delivered").

### Admin Dashboard
* **Catalog Management**: Add, update, and delete categories and products.
* **Order Management**: View incoming orders, update order statuses (Ordered, On Delivery, Delivered, Cancelled), and manage customer details.
* **Stock & Inventory Control**: Track product stock quantities. The dashboard alerts admins of Low Stock, and the system automatically deducts stock upon successful checkouts.
* **Admin Management**: Create and manage sub-admins.

## 📁 Project Architecture (Domain-Driven)

The codebase has been refactored from a flat structure into a feature-based / domain-driven architecture for better maintainability:

```text
MedBD/
├── admin/               # Admin dashboard and management scripts
├── cart/                # Shopping cart UI, add, update, and remove logic
├── catalog/             # Product listings, categories, search, reviews
├── checkout/            # Checkout flow, Stripe processing, and order emails
├── config/              # Core configurations (DB connection, Mailer helper)
├── customer/            # User authentication (Login, Register, OTP, Profile)
├── css/                 # Global styling and specific component stylesheets
├── images/              # Static assets (logos, products, categories, favicon)
├── pages/               # Static and informational pages (Contact)
├── partials-front/      # Reusable frontend components (Header, Footer, Menu)
├── sql/                 # Database schema and sequential migrations
└── wishlist/            # Wishlist UI and logic
```

## 🛠️ Technology Stack

* **Frontend**: HTML5, Vanilla CSS, BoxIcons for iconography.
* **Backend**: PHP (Procedural).
* **Database**: MySQL.
* **Integrations**: 
  * Stripe API (Payment Processing)
  * PHPMailer (SMTP Email Sending)

## ⚙️ Installation & Setup

### Prerequisites
* A local server environment like XAMPP, LAMPP, or WAMP.
* PHP 8.0+
* MySQL Database

### Step 1: Clone the Repository
Clone the repository into your local server's document root (e.g., `/opt/lampp/htdocs/` or `C:\xampp\htdocs\`).

```bash
git clone <repository_url> MedBD
```

### Step 2: Database Setup
1. Open phpMyAdmin or your preferred MySQL client.
2. Create a new database named `medbd`.
3. Import the base database schema: `sql/medbd.sql`.
4. Run the subsequent migration files located in the `sql/` directory in order:
   * `migration_v2.sql` (Reviews and schema updates)
   * `migration_v3.sql` (Stock management)
   * `migration_v4.sql` (OTP Verification columns)

### Step 3: Configuration
Open `config/constants.php` and update the following credentials to match your environment:

1. **Database Credentials**:
   ```php
   define('LOCALHOST', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_NAME', 'medbd');
   ```

2. **Site URL**:
   Ensure `SITEURL` points exactly to your local directory (include the trailing slash).
   ```php
   define('SITEURL', 'http://localhost/MedBD/');
   ```

3. **Stripe API Keys**:
   Add your Stripe test keys for payment processing.
   ```php
   define('STRIPE_PUBLISHABLE_KEY', 'your_publishable_key');
   define('STRIPE_SECRET_KEY', 'your_secret_key');
   ```

4. **SMTP Credentials (PHPMailer)**:
   Add your SMTP details to enable OTP and Order Confirmation emails. If using Gmail, you will need to generate an App Password.
   ```php
   define('SMTP_USERNAME', 'your_email@gmail.com');
   define('SMTP_PASSWORD', 'your_app_password');
   ```

### Step 4: Run the Application
Open your browser and navigate to:
`http://localhost/MedBD/`

To access the admin dashboard:
`http://localhost/MedBD/admin/`

## 🛡️ License & Academic Context
This project was developed as a comprehensive semester project to demonstrate a feasible, secure, and modern approach to building an online medical e-commerce platform.