# Run ODDS Portfolio locally

This project uses Laravel 12, PHP 8.2+, Composer, Node.js, and Vite. Use Node.js 22.12+ (or a supported newer release).

## Start the app

From the project folder in PowerShell:

```powershell
npm.cmd run dev:all
```

Open http://127.0.0.1:8000. This command starts Laravel, the queue worker, and Vite with live reload. Keep the terminal open; press Ctrl+C to stop.

Admin login: http://127.0.0.1:8000/admin/login. The application's default local credentials are username `admin` and password `adminpassword`. Override them with `ADMIN_USERNAME` and `ADMIN_PASSWORD` in `.env` when needed.

For a simple server using already built assets:

```powershell
npm.cmd run build
php artisan serve
```

## Set up a fresh clone

```powershell
composer install
npm.cmd ci
Copy-Item .env.example .env
New-Item database/database.sqlite -ItemType File
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm.cmd run build
```

Run the copy and database creation commands only when those files do not already exist. The seeders populate the portfolio's initial content; use them on a fresh database, since rerunning seeders can replace edited content.

The local database is `database/database.sqlite`. `.env`, dependencies, generated assets, and the database are ignored by Git. Set `APP_URL=http://127.0.0.1:8000` in `.env` for local links.

PowerShell on this machine blocks `npm.ps1`; `npm.cmd` works without changing the execution policy.

## Optional services and verification

The AI chat feature requires `GROQ_API_KEY` in `.env`. Email defaults to the log mailer, so messages appear in `storage/logs/laravel.log`; configure SMTP to send real email. External service credentials are not needed to serve the portfolio locally.

```powershell
php artisan test
```

After changing `.env`, run `php artisan config:clear` and restart the app. If port 8000 is occupied, stop the process using it or run `php artisan serve --port=8001` and use that address.
