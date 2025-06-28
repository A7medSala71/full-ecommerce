# 🛒 Full eCommerce Website

This project is a complete **eCommerce website** built using **PHP, MySQL, HTML, CSS, Bootstrap, and JavaScript**. It includes essential features for both users and admins such as product listing, user authentication, order management, cart system, and more.

## 📁 Project Path

Make sure to place the unzipped folder into the following path for local development:

```
C:\xampp\htdocs\full ecommerce\full ecommerce
```

> You can rename the inner folder for easier access, e.g., `C:\xampp\htdocs\ecommerce`

---

## ⚙️ Getting Started

Follow these instructions to set up and run the project locally using **XAMPP**:

### 1. Requirements

- [XAMPP](https://www.apachefriends.org/index.html) (Apache + MySQL)
- Web browser (e.g., Chrome, Firefox)

### 2. Installation

1. Open **XAMPP Control Panel**.
2. Start **Apache** and **MySQL**.
3. Copy the project folder to:
   ```
   C:\xampp\htdocs\
   ```
4. Navigate to `http://localhost/phpmyadmin` in your browser.
5. Create a new database:
   ```
   ecommerce
   ```
6. Import the included `.sql` file:
   - Go to the `Import` tab.
   - Select the `ecommerce.sql` file located in the root of the project folder.
   - Click **Go** to import.

### 3. Run the Website

Visit:
```
http://localhost/full ecommerce/full ecommerce/
```

> If renamed to `ecommerce`, visit `http://localhost/ecommerce/`

---

## 👨‍💻 Features

### 🛍️ User Features
- Browse product categories
- View product details
- Add to cart
- Place orders
- User signup/login
- Order history

### 🛠️ Admin Features
- Admin login
- Add/edit/delete products
- Manage categories
- View and manage orders
- View user messages

---

## 📁 Folder Structure Overview

```
/full ecommerce/
│
├── admin/              → Admin panel files
├── cart.php            → Shopping cart logic
├── checkout.php        → Checkout functionality
├── config/             → Database connection
├── contact.php         → Contact form
├── css/                → Stylesheets
├── img/                → Product and site images
├── js/                 → JavaScript functionality
├── login.php           → User login
├── logout.php          → Logout script
├── product.php         → Product display
├── register.php        → User registration
├── search.php          → Search logic
├── sql/ecommerce.sql   → Database schema
└── index.php           → Homepage
```

---

## 🛠️ Technologies Used

- **PHP** – Server-side scripting
- **MySQL** – Database
- **HTML5/CSS3** – Structure and styling
- **Bootstrap 5** – Responsive UI components
- **JavaScript** – Interactivity
- **XAMPP** – Local development server

---

## 📩 Contact

For questions or support, please contact:

**Developer:** [Your Name]  
**Email:** [your.email@example.com]  
**GitHub:** [https://github.com/yourusername](https://github.com/yourusername)

---

## 📜 License

This project is licensed under the MIT License. You are free to use, modify, and distribute it.
