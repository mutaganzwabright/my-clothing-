# Clothing Store

A modern, responsive e-commerce website built with PHP and Tailwind CSS.

## Features

- User registration and login
- Product browsing and search
- Shopping cart functionality
- Order management
- Admin dashboard
- Responsive design

## Setup

1. Start XAMPP and ensure Apache and MySQL are running.

2. **CRITICAL: Import the database** (required for products to display):
   - Open phpMyAdmin at `http://localhost/phpmyadmin`
   - Create a new database named `clothing_store`
   - Import the `setup.sql` file from your project root
   - This creates tables and populates 50+ products with placeholder images

3. Configure database connection in `includes/config.php` if needed (default should work).

4. The `uploads` folder is created automatically for future product images.

5. Access the site at `http://localhost/clothing_store`

## Default Accounts

- Admin: admin@example.com / password
- User: user@example.com / password

## Technologies Used

- PHP 7+
- MySQL
- Tailwind CSS
- Font Awesome