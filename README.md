# Lara Assessment – Production Ready Laravel 11 API

A production-ready RESTful API built using Laravel 11, Sanctum, and MySQL.

This project demonstrates:

- Clean Architecture
- Service Layer Pattern
- Proper Database Design
- Concurrency Handling (Prevent Overselling)
- Optimized Queries
- Caching
- Token-based Authentication
- Structured JSON Responses
- Feature Testing

---

## 🚀 Tech Stack

- PHP 8.2+
- Laravel 11
- MySQL
- Laravel Sanctum
- RESTful API Architecture

---

# 📦 Installation Guide

## 1️⃣ Clone Repository

```bash
git clone https://github.com/your-username/lara-sanctum.git
cd lara-sanctum

2️⃣ Install Dependencies
composer install
3️⃣ Create Environment File
cp .env.example .env

Generate application key:

php artisan key:generate
4️⃣ Configure Database

Update .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lara_assessment
DB_USERNAME=root
DB_PASSWORD=
5️⃣ Run Migrations
php artisan migrate:fresh

If using seeders:

php artisan migrate:fresh --seed
6️⃣ Install Sanctum (If Fresh Setup)
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
7️⃣ Start Server
php artisan serve

Server runs at:

http://127.0.0.1:8000
🔐 Authentication

Token-based authentication using Laravel Sanctum.

Login Endpoint
POST /api/v1/login
Request Body
{
  "email": "husain@test.com",
  "password": "password"
}
Response
{
  "token": "1|xxxxxxxxxxxxxxxx"
}

Use this token in headers:

Authorization: Bearer YOUR_TOKEN
Accept: application/json

📦 Order Creation API

POST /api/v1/orders
Headers

Authorization: Bearer YOUR_TOKEN
Accept: application/json

Request Body
{
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 2, "quantity": 1 }
  ]
}

Features

Input validation

Product existence check

Stock validation

18% tax calculation

Snapshot price storage

Database transactions

Row-level locking (lockForUpdate)

Prevents overselling

Structured JSON response

📊 Analytics API
GET /api/v1/analytics/top-spenders

Returns

Top 5 users

Total amount spent

Number of orders

Pagination support

Cached for 60 seconds

Optimized SQL (No N+1 queries)

🧠 Architecture
app/
 ├── Services/
 ├── Exceptions/
 ├── Http/
 │    ├── Controllers/Api
 │    ├── Requests
 │    ├── Resources
 ├── Models
Principles Used

Thin Controllers

Service Layer Pattern

Form Request Validation

Centralized Exception Handling

RESTful Structure

Clean Naming Conventions

🔄 Concurrency Handling

To prevent overselling:

Database transaction used

lockForUpdate() applied

Atomic stock decrement

Indexed columns

🧪 Running Tests
php artisan test

Feature tests cover:

Authentication

Order creation

Stock validation

API responses

🛠 Useful Commands

Clear cache:

php artisan optimize:clear

Re-run migrations:

php artisan migrate:fresh

⚠ Important Notes

Always send Accept: application/json header for API routes.

Do not test protected routes directly in browser.

Use Postman or similar tool.

🚀 Production Deployment Tips

Use Nginx + PHP-FPM

Enable OPcache

Use Redis for caching

Run queue workers via Supervisor

Set APP_ENV=production

Disable debug mode

👨‍💻 Author

Athar Husain
Senior PHP / Laravel Developer
