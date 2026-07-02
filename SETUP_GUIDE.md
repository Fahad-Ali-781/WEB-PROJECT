# E-Commerce Site - Setup Instructions

## Project Overview
This is a complete e-commerce application built with:
- **Backend**: Laravel 12
- **Frontend**: Bootstrap 5 with HTML, CSS, and JavaScript
- **Database**: MySQL

## Features

### Customer Features
- Product browsing with categories
- Product search functionality
- Shopping cart with add/remove/update items
- Checkout process
- Order management
- User authentication

### Admin Features
- Category management (CRUD)
- Product management (CRUD)
- Order management

## Database Setup

### 1. Create Database
```bash
# In MySQL
CREATE DATABASE ecommerce;
```

### 2. Configure .env File
The `.env` file is already configured with:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

If you want Google or Facebook login, also set these values from your OAuth app dashboard:
```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback

FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT_URI=${APP_URL}/auth/facebook/callback
```

After changing these values, clear cached config with:
```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Run Migrations and Seeders
```bash
php artisan migrate --seed
```

This will create all necessary tables and populate sample data.

## Project Structure

### Database Tables
- **users**: User accounts
- **categories**: Product categories
- **products**: Product listings
- **carts**: Shopping carts
- **cart_items**: Items in carts
- **orders**: Customer orders
- **order_items**: Items in orders

### Models
- User
- Category
- Product
- Cart
- CartItem
- Order
- OrderItem

### Controllers
- ProductController: Browse products, categories, search
- CartController: Manage shopping cart
- OrderController: Checkout and order management
- AdminController: Manage categories and products

### Views
```
resources/views/
├── layouts/
│   └── app.blade.php (Main layout)
├── welcome.blade.php (Home page)
├── products/
│   ├── index.blade.php (Product listing)
│   └── show.blade.php (Product details)
├── cart/
│   └── index.blade.php (Shopping cart)
├── orders/
│   ├── checkout.blade.php (Checkout form)
│   ├── index.blade.php (My orders)
│   └── show.blade.php (Order details)
└── auth/
    ├── login.blade.php (Login page)
    └── register.blade.php (Registration page)
```

## Running the Application

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Generate Application Key
```bash
php artisan key:generate
```

### 3. Run Database Setup
```bash
php artisan migrate --seed
```

### 4. Start the Development Server
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

### 5. (Optional) Start Vite Dev Server
In another terminal:
```bash
npm run dev
```

## Default Test User
- **Email**: test@example.com
- **Password**: password

## Routes Overview

### Public Routes
- `/` - Home page
- `/products` - Product listing
- `/products/{id}` - Product details
- `/category/{slug}` - Category products
- `/search` - Search products

### Authenticated Routes (require login)
- `/cart` - Shopping cart
- `/checkout` - Checkout page
- `/orders` - My orders
- `/orders/{id}` - Order details

### Admin Routes (require login)
- `/admin/categories` - Manage categories
- `/admin/products` - Manage products

## Features Implementation

### 1. Product Catalog
- Browse all products with pagination
- Filter by category
- Search products by name or description
- View product details

### 2. Shopping Cart
- Add products to cart
- Update quantity
- Remove items
- View cart total

### 3. Checkout & Orders
- Enter shipping information
- Select payment method
- Place order
- View order history and details

### 4. User Authentication
- Register new account
- Login/Logout
- Password management

### 5. Admin Management
- Create/Edit/Delete categories
- Create/Edit/Delete products
- Manage inventory

## Styling

### Bootstrap 5
- Responsive design
- Professional UI components
- Mobile-friendly layout

### Custom Styles
- Modern color scheme (Primary: #FF6B6B, Secondary: #4ECDC4)
- Card-based product layout
- Smooth animations and transitions
- Gradient backgrounds

## API Endpoints Summary

| Method | Route | Controller | Function |
|--------|-------|-----------|----------|
| GET | /products | ProductController | index |
| GET | /products/{id} | ProductController | show |
| GET | /category/{slug} | ProductController | byCategory |
| GET | /search | ProductController | search |
| POST | /cart/add | CartController | add |
| DELETE | /cart/{item} | CartController | remove |
| PUT | /cart/{item} | CartController | update |
| DELETE | /cart | CartController | clear |
| GET | /checkout | OrderController | checkout |
| POST | /checkout | OrderController | store |
| GET | /orders | OrderController | index |
| GET | /orders/{id} | OrderController | show |

## Sample Data

The database seeder creates:
- 4 Categories: Electronics, Fashion, Home & Garden, Books
- 8 Products with sample data
- 1 Test user account

## Troubleshooting

### Database Connection Error
- Ensure MySQL is running
- Verify database credentials in .env
- Check if ecommerce database exists

### Page Not Found Errors
- Run migrations: `php artisan migrate`
- Clear cache: `php artisan cache:clear`

### Authentication Issues
- Clear auth sessions: `php artisan cache:clear`
- Regenerate app key if needed: `php artisan key:generate`

## Next Steps

1. Customize styling in resources/css/app.css
2. Add product images support
3. Implement payment gateway integration
4. Add email notifications
5. Setup order status tracking
6. Add admin dashboard
7. Implement user reviews and ratings

## Security Notes

- Change default test user credentials in production
- Enable HTTPS in production
- Implement proper validation on all forms
- Add rate limiting to prevent abuse
- Regular database backups

---

For more information, visit [Laravel Documentation](https://laravel.com/docs)
