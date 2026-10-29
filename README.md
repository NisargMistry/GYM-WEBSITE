# 🏋️ GYM Website Management System

A full-stack gym membership web application built with PHP, MySQL, HTML/CSS, and JavaScript. It allows users to register, log in, calculate their BMI, browse gym membership packages, add them to a cart, and complete checkout.

---

## 📁 Project Structure

```
gym-website/
│
├── index.html                  # Landing page (entry point)
├── README.md
│
├── assets/
│   ├── css/
│   │   ├── style.css           # Landing page styles
│   │   ├── register.css        # Shared auth page styles
│   │   ├── Bmi2.css            # BMI calculator styles
│   │   └── cart.css            # Cart background style
│   │
│   ├── js/
│   │   ├── script.js           # Mobile navbar toggle
│   │   └── bmi.js              # BMI calculation logic
│   │
│   ├── images/
│   │   ├── logo.jpg
│   │   ├── back.jpg
│   │   ├── male.jpg            # Package image – 1 Year
│   │   ├── female.jpeg         # Package image – 6 Month
│   │   ├── 1month.jpg          # Package image – 1 Month
│   │   ├── 2month.jpg          # Package image – 3 Month
│   │   ├── 2year.jpg           # Package image – 2 Year
│   │   ├── 3year.jpg           # Package image – 3 Year
│   │   └── GYM WEBSITE VIDEO.gif
│   │
│   └── img.txt                 # Image reference notes
│
├── php/
│   ├── config.php              # Database connection configuration
│   ├── login.php               # Login form & logic
│   ├── register.php            # Registration form & logic
│   ├── logout.php              # Session destroy & redirect
│   ├── welcome.php             # Post-login dashboard
│   ├── bmi1.php                # BMI Calculator page
│   ├── addtocart.php           # Package listing page
│   ├── cart.php                # Shopping cart view
│   ├── checkout.php            # Checkout form
│   └── action.php              # AJAX backend handler (cart & orders)
│
└── database/
    └── GYM.sql                 # MySQL schema + seed data
```

---

## ✨ Features

### 🏠 Landing Page (`index.html`)
- Responsive navbar with mobile hamburger menu
- Hero section with gym workout description
- "Why Choose Us" section
- Explore Fitness Studio section
- Professional Trainers section with profile cards
- Client Testimonial section
- Seasonal discount promotion banner
- Footer

### 👤 User Authentication
- **Register** (`register.php`) — Create a new account with username, password (min 5 chars), confirm password, address, city, state, and ZIP. Passwords are hashed using PHP's `password_hash()`.
- **Login** (`login.php`) — Authenticate with username + password using prepared statements. Session is started on success.
- **Logout** (`logout.php`) — Destroys the session and redirects to login with a JavaScript alert.
- **Welcome Dashboard** (`welcome.php`) — Protected page. Redirects to login if not authenticated. Displays username and navigation to BMI Calculator and Package Booking.

### 🧮 BMI Calculator (`bmi1.php` + `bmi.js`)
- Accepts height (cm) and weight (kg) inputs
- Calculates BMI on the client side using JavaScript
- Classifies the result into: **Underweight**, **Healthy**, **Overweight**, or **Obesity**
- Each category links to a downloadable PDF diet plan
- Accessible only to logged-in users (session-guarded page)

### 🛍️ Membership Package Store
- **Package Listing** (`addtocart.php`) — Fetches all products from the database and displays them as Bootstrap cards. Packages available:
  | Package | Price (₹) |
  |---------|-----------|
  | 1-Month | 900       |
  | 3-Month | 2,500     |
  | 6-Month | 5,000     |
  | 1-Year  | 7,000     |
  | 2-Year  | 14,000    |
  | 3-Year  | 28,000    |
- Add to cart via AJAX (no page reload)
- Live cart item count badge in navbar

### 🛒 Cart (`cart.php`)
- View all added packages in a table
- Update item quantity (triggers AJAX update)
- Remove a single item or clear the entire cart
- Grand total calculated dynamically
- Checkout button enabled only when cart has items

### 💳 Checkout (`checkout.php` + `action.php`)
- Displays items and total amount payable
- Collect customer: Name, Email, Phone, Delivery Address, Payment Mode
- Payment options: Cash on Delivery, Net Banking, Debit/Credit Card
- On successful order:
  - Inserts into `orders` table
  - Clears the `cart` table
  - Shows a "Thank You" confirmation with order summary

### ⚙️ AJAX Action Handler (`action.php`)
Central backend handler managing all cart and order operations:
- `POST pid` → Add product to cart
- `GET cartItem=cart_item` → Return cart item count
- `GET remove={id}` → Remove single cart item
- `GET clear` → Clear entire cart
- `POST qty` → Update item quantity and recalculate total
- `POST action=order` → Process order and save to database

---

## 🗄️ Database Schema

**Database name:** `nisarg`

### Tables

#### `users`
| Column      | Type         | Description                    |
|-------------|--------------|--------------------------------|
| id          | INT (PK, AI) | Unique user ID                 |
| username    | VARCHAR(50)  | Unique username                |
| password    | VARCHAR(255) | Bcrypt hashed password         |
| create_at   | DATETIME     | Account creation timestamp     |

#### `product`
| Column        | Type         | Description                  |
|---------------|--------------|------------------------------|
| id            | INT (PK, AI) | Product ID                   |
| product_name  | VARCHAR(255) | Package name (e.g. "1-Month")|
| product_price | VARCHAR(100) | Price in INR                 |
| product_qty   | INT          | Default quantity (1)         |
| product_image | VARCHAR(255) | Image filename               |
| product_code  | VARCHAR(50)  | Unique product code          |

#### `cart`
| Column        | Type         | Description               |
|---------------|--------------|---------------------------|
| id            | INT (PK, AI) | Cart entry ID             |
| product_name  | VARCHAR(100) | Package name              |
| product_price | VARCHAR(50)  | Unit price                |
| product_image | VARCHAR(255) | Image path                |
| qty           | INT          | Selected quantity         |
| total_price   | VARCHAR(100) | qty × price               |
| product_code  | VARCHAR(10)  | Product identifier        |

#### `orders`
| Column      | Type         | Description                    |
|-------------|--------------|--------------------------------|
| id          | INT (PK, AI) | Order ID                       |
| name        | VARCHAR(100) | Customer name                  |
| email       | VARCHAR(100) | Customer email                 |
| phone       | VARCHAR(20)  | Customer phone                 |
| address     | VARCHAR(255) | Delivery address               |
| pmode       | VARCHAR(50)  | Payment mode                   |
| products    | VARCHAR(255) | Comma-separated items + qty    |
| amount_paid | VARCHAR(100) | Grand total paid               |

---

## 🔄 Application Flow

```
[Landing Page - index.html]
        │
        ├──> [Register - register.php]
        │         │
        │         └──> [Login - login.php]
        │
        └──> [Login - login.php]
                  │
                  └──> [Welcome Dashboard - welcome.php]
                            │
                            ├──> [BMI Calculator - bmi1.php]
                            │         │
                            │         └──> [Package Store - addtocart.php]
                            │
                            └──> [Package Store - addtocart.php]
                                      │
                                      ├──> [Cart - cart.php]
                                      │         │
                                      │         └──> [Checkout - checkout.php]
                                      │                    │
                                      │                    └──> [Order Confirmed]
                                      │
                                      └──> [action.php] (AJAX handler)
```

---

## 🛠️ Technology Stack

| Layer        | Technology                        |
|--------------|-----------------------------------|
| Frontend     | HTML5, CSS3, JavaScript (ES6)     |
| UI Framework | Bootstrap 4.3                     |
| Icons        | Font Awesome 5, Ionic Icons       |
| Backend      | PHP 8.x                           |
| Database     | MySQL / MariaDB (via mysqli)      |
| AJAX         | jQuery 3.5                        |
| Fonts        | Google Fonts (Nunito, Old Standard TT) |
| Server       | Apache / XAMPP (localhost)        |

---

## ⚠️ Challenges & Known Issues

### 1. No Cart–User Association
The `cart` table has no `user_id` column, so cart items are shared across all sessions. If two users are active simultaneously, they will see each other's cart contents.

### 2. Form Fields Without Backend Binding
In `register.php`, the Address, City, State, and ZIP fields are rendered in the UI but their values are never submitted to or stored in the database. Only `username` and `password` are processed.

### 3. SQL Injection Risk in `action.php`
Most queries use prepared statements correctly, but the checkout `action=order` block accepts raw POST data without sanitization before inserting into the `orders` table.

### 4. Duplicate `session_start()` in `login.php`
`session_start()` is called twice — once at the top of the file and again inside the password-verification block. This can cause PHP warnings depending on server configuration.

### 5. `logout.php` Header After Output
`logout.php` calls `echo` before `header()`, which can cause "headers already sent" warnings.

### 6. Hardcoded Database Credentials
`config.php` stores database credentials in plain text constants. These should be moved to environment variables (`.env`) for any non-local deployment.

### 7. No Input Sanitization for Displayed Data
User-supplied values (e.g. product names, customer info) are echoed back directly without `htmlspecialchars()`, leaving the app open to stored XSS.

### 8. Cart Duplication Allowed by Product Code Only
Duplicate prevention in `action.php` checks `product_code` against the shared cart table, not per-user. A user cannot add the same package twice, but the check is global.

---

## 🚀 Setup & Installation

### Prerequisites
- XAMPP / WAMP / LAMP (PHP 8+, Apache, MySQL/MariaDB)
- Web browser

### Steps

1. **Clone or copy** this project into your web server's root directory:
   ```
   C:/xampp/htdocs/gym/
   ```

2. **Import the database** via phpMyAdmin or CLI:
   ```sql
   -- In phpMyAdmin: create a database named "nisarg", then import GYM.sql
   ```
   Or via CLI:
   ```bash
   mysql -u root -p nisarg < GYM.sql
   ```

3. **Configure the database** in `config.php` if your credentials differ:
   ```php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_NAME', 'nisarg');
   ```

4. **Start Apache and MySQL** in XAMPP Control Panel.

5. **Open in browser:**
   ```
   http://localhost/gym/index.html
   ```

   All PHP files are under `php/` and will work relative to the project root. Images are served from `assets/images/`.

---

## 👤 Author

**Nisarg Mistry**  
Project built as a full-stack PHP + MySQL gym management mini-application.

---

## 📄 License

This project is for educational purposes. Feel free to extend and improve it.
