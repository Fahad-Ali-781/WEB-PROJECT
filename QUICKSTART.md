# COMMERCE - Quick Start Guide

## 🚀 Getting Started

Your complete e-commerce application is ready! Follow these steps to get it running:

### Step 1: Database Setup

1. **Create MySQL Database**
   - Open MySQL Command Line or phpMyAdmin
   - Create a new database: `CREATE DATABASE ecommerce;`

2. **Configure .env** (Already done ✓)
   - The `.env` file is already configured for MySQL

3. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```
   This will:
   - Create all database tables
   - Populate sample categories
   - Add sample products
   - Create a test user account

### Step 2: Start the Application

```bash
# In your project directory
php artisan serve
```

The application will be available at: **http://localhost:8000**

If VS Code opens the site in its built-in preview instead of Chrome, run [`open-in-browser.bat`](open-in-browser.bat) after starting the server to launch the site directly in your default browser or Chrome.

### Step 3: Login

Use the default test account:
- **Email**: test@example.com
- **Password**: password

---

## 📋 What's Included

### ✅ Database Tables
- Users (for authentication)
- Categories (product categories)
- Products (product listings)
- Carts (shopping carts)
- Cart Items (items in carts)
- Orders (customer orders)
- Order Items (items in orders)

### ✅ Features Implemented

#### Customer Features
- ✓ Browse all products with pagination
- ✓ Filter by category
- ✓ Search products
- ✓ View product details
- ✓ Add/remove items from cart
- ✓ View shopping cart
- ✓ Checkout process
- ✓ Place orders
- ✓ View order history
- ✓ User registration and login

#### Admin Features  
- ✓ Manage categories (Create, Read, Update, Delete)
- ✓ Manage products (Create, Read, Update, Delete)
- ✓ Product featured status
- ✓ Inventory management

### ✅ Frontend
- Modern Bootstrap 5 design
- Responsive layout
- Beautiful color scheme
- Smooth animations
- Mobile-friendly interface
- Professional product cards
- Easy navigation

### ✅ Backend
- Laravel 12 framework
- MySQL database
- RESTful routes
- Authentication system
- Model relationships
- Data validation

---

## 🎨 Key Views

### Public Pages
- **Home** (`/`) - Welcome page with featured products
- **Products** (`/products`) - All products with filters
- **Product Detail** (`/products/{id}`) - Product information
- **Categories** (`/category/{slug}`) - Products by category
- **Search** (`/search`) - Product search results

### Authenticated Pages
- **Cart** (`/cart`) - Shopping cart management
- **Checkout** (`/checkout`) - Order placement
- **My Orders** (`/orders`) - Order history
- **Order Detail** (`/orders/{id}`) - Order information

### Admin Pages
- **Categories** (`/admin/categories`) - Category management
- **Products** (`/admin/products`) - Product management

---

## 📁 Project Structure

```
commerce/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ProductController.php
│   │       ├── CartController.php
│   │       ├── OrderController.php
│   │       └── AdminController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   ├── Cart.php
│   │   ├── CartItem.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/ (6 new migrations)
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── welcome.blade.php
│       ├── products/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── cart/
│       │   └── index.blade.php
│       ├── orders/
│       │   ├── checkout.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       └── admin/
│           ├── categories/
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   └── edit.blade.php
│           └── products/
│               ├── index.blade.php
│               ├── create.blade.php
│               └── edit.blade.php
└── routes/
    ├── web.php (main routes)
    └── auth.php (authentication routes)
```

---

## 🔐 User Roles & Permissions

### Customer
- Browse products freely
- Create account
- Manage shopping cart
- Place orders
- View order history

### Admin
- All customer features +
- Create, edit, delete categories
- Create, edit, delete products
- Manage product inventory
- Mark products as featured

---

## 🎯 Sample Data

The seeder creates:
- **4 Categories**
  - Electronics
  - Fashion
  - Home & Garden
  - Books

- **8 Products**
  - Wireless Headphones (Featured)
  - USB-C Cable
  - Cotton T-Shirt (Featured)
  - Denim Jeans
  - Table Lamp (Featured)
  - Plant Pot
  - The Great Gatsby
  - To Kill a Mockingbird (Featured)

---

## 🛠️ Common Commands

```bash
# Serve the application
php artisan serve

# Run migrations only
php artisan migrate

# Run seeders
php artisan db:seed

# Clear cache
php artisan cache:clear

# Create new migration
php artisan make:migration create_table_name

# Create new model
php artisan make:model ModelName

# Create new controller
php artisan make:controller ControllerName
```

---

## 🔌 API Routes Summary

| Method | Route | Purpose |
|--------|-------|---------|
| GET | /products | List all products |
| GET | /products/{id} | View product |
| GET | /category/{slug} | Products by category |
| GET | /search?q=term | Search products |
| POST | /cart/add | Add to cart |
| DELETE | /cart/{item} | Remove from cart |
| PUT | /cart/{item} | Update cart item |
| GET | /checkout | Checkout page |
| POST | /checkout | Place order |
| GET | /orders | My orders |
| GET | /orders/{id} | Order details |

---

## 🎨 Styling & Design

### Color Palette
- **Primary**: #FF6B6B (Red)
- **Secondary**: #4ECDC4 (Teal)
- **Dark**: #2C3E50
- **Light**: #F7F7F7

### Features
- Gradient backgrounds
- Smooth transitions
- Hover effects on cards
- Professional typography
- Responsive grid layout

---

## 📝 Next Steps (Future Enhancements)

1. Add product image uploads
2. Implement payment gateway
3. Email notifications
4. Order status updates
5. User reviews and ratings
6. Wishlist feature
7. Advanced search filters
8. Discount codes
9. Admin dashboard
10. Customer support chat

---

## ❓ Troubleshooting

### Database Connection Error
```bash
# Check credentials in .env
# Verify MySQL is running
# Create the ecommerce database manually if needed
```

### "SQLSTATE[HY000] [2002]" Connection Refused
```bash
# Start MySQL service
# Windows: Use XAMPP Control Panel
# Mac/Linux: brew services start mysql
```

### Missing Tables
```bash
# Run migrations
php artisan migrate --seed
```

### Authentication Not Working
```bash
# Clear cache
php artisan cache:clear

# Regenerate app key if needed
php artisan key:generate
```

---

## 📚 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

## ✨ That's It!

Your e-commerce site is ready to use. Start shopping or log in as admin to manage products!

**Enjoy building!** 🎉
