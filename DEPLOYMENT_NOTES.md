# Deployment Notes

## GitHub Pages

GitHub Pages should only be used for the static preview page: `index.html`.
It will not run the Laravel application.

## Laravel hosting checklist

1. Upload the project to PHP hosting.
2. Set the web root/document root to the `public` folder.
3. Create a production `.env` file.
4. Set database credentials.
5. Run:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

6. Make sure `storage` and `bootstrap/cache` are writable.

## GitHub Pages preview

The included `index.html` is a static landing page for the GitHub Pages URL. It is not the live Laravel system.
