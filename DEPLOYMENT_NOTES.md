# Deployment notes

> HanaShop is a **proof of concept**, not a production e-commerce platform. These notes describe how the static preview is published and what a hosted trial would require. They are not an invitation to run it for real customers.

## GitHub Pages (static preview only)

GitHub Pages serves the static preview page, `index.html`. It does not run the Laravel application.

## Hosting the Laravel application for a private trial

1. Upload the project to PHP hosting.
2. Set the web root to the `public` folder.
3. Create a production `.env` file and set the database credentials.
4. Run:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

5. Make sure `storage` and `bootstrap/cache` are writable.

**Do not run `php artisan migrate --seed` on a hosted database.** The seeder creates a demo administrator with a placeholder password and fictional customers. It exists for local development only.

Before exposing a hosted trial to anyone, also disable public registration and restrict the dashboard to a dedicated administrator role. Both are open limitations of this proof of concept.
