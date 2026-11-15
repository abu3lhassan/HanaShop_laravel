# HanaShop

> **Proof of Concept.** HanaShop is an experimental learning project that explores a Laravel storefront with an admin dashboard. It is **not a production e-commerce platform** and must not be deployed to handle real customers, orders, or payments.

A small online store for home decor, kitchen tools, and electronics: a public storefront and a back-office dashboard, built with Laravel.

## What it demonstrates

- Public storefront: categories, product pages, and a session-based shopping cart
- Order checkout that records the customer and the order. There is **no payment processing**
- Admin dashboard: products, categories, product details, customers, invoices, store settings, and admin users
- Light and dark theme options
- A static preview page (`index.html`) that can be served with GitHub Pages. It shows the design only; **it does not run the Laravel application**

## Technology

PHP 8.2+, Laravel 11, Blade templates, Tailwind CSS 3, Bootstrap 5, and Vite.

## Run it locally

```bash
composer install
cp .env.example .env
php artisan key:generate
# set your local database in .env
php artisan migrate --seed       # local development only, see the note below
npm install
npm run dev                      # in one terminal
php artisan serve                # in another
```

**About the demo data.** `--seed` fills the database with fictional products and customers and creates a demo administrator account with a placeholder password, for local use only. Never run the seeder against a database that anyone else can reach, and never deploy this project with the demo account in place.

## Known limitations

This project is intentionally minimal, and it is not hardened for public use:

- Admin pages require sign-in but have no separate administrator role
- Public registration is enabled
- No payment gateway, and no automated tests beyond the Laravel scaffold
- Demo data and a demo administrator are created by the seeder

## Status

Proof of concept; not maintained as a product. Developed by [Ali Al-Hanabi](https://www.alhanabi.com).
