# R.G. Ambulance – Vercel Deployment Guide

## Architecture

This project deploys Laravel 12 on Vercel's serverless PHP runtime.

```
vercel.json          → Builds + routes config
api/index.php        → Serverless PHP entry point
public/              → Static assets (served by Vercel CDN)
bootstrap/app.php    → Laravel bootstrap (unchanged)
```

---

## File Tree (Vercel-relevant)

```
R.G.-Ambulance-vercel/
├── api/
│   └── index.php              ← Serverless entry point
├── public/
│   ├── build/                 ← Vite-built CSS/JS (versioned)
│   ├── css/
│   ├── js/
│   ├── vendor/                ← Filament vendor assets
│   ├── storage/               ← Symlink to storage/app/public
│   ├── favicon.ico
│   ├── robots.txt
│   ├── index.php              ← Original Laravel entry (unused on Vercel)
│   └── .htaccess
├── bootstrap/
│   ├── app.php
│   └── cache/                 ← Config/route/view cache written during build
├── storage/
├── vendor/                    ← Installed during `composer install --no-dev`
├── vercel.json                ← Vercel deployment config
├── .vercelignore
└── README-VERCEL.md           ← This file
```

---

## Files Changed / Created

| File | Action |
|---|---|
| `vercel.json` | **Rewritten** – static builds + PHP function + filesystem routing |
| `api/index.php` | **Rewritten** – maintenance check, /tmp storage redirect, Laravel bootstrap |
| `.vercelignore` | **Rewritten** – refined exclusion list |

All other files remain exactly as in the original project.

---

## Full File Contents

### `vercel.json`

```json
{
    "version": 2,
    "framework": null,
    "buildCommand": "composer install --no-dev --no-interaction --prefer-dist && php artisan config:cache && php artisan route:cache && php artisan view:cache",
    "builds": [
        {
            "src": "public/**",
            "use": "@vercel/static"
        },
        {
            "src": "api/index.php",
            "use": "@vercel/php"
        }
    ],
    "routes": [
        {
            "src": "/build/(.*)",
            "dest": "/public/build/$1",
            "headers": {
                "cache-control": "public, max-age=31536000, immutable"
            }
        },
        {
            "src": "/vendor/(.*)",
            "dest": "/public/vendor/$1"
        },
        {
            "src": "/css/(.*)",
            "dest": "/public/css/$1"
        },
        {
            "src": "/js/(.*)",
            "dest": "/public/js/$1"
        },
        {
            "src": "/storage/(.*)",
            "dest": "/public/storage/$1"
        },
        {
            "src": "/favicon\\.ico",
            "dest": "/public/favicon.ico"
        },
        {
            "src": "/robots\\.txt",
            "dest": "/public/robots.txt"
        },
        {
            "handle": "filesystem"
        },
        {
            "src": "/(.*)",
            "dest": "/api/index.php"
        }
    ],
    "cleanUrls": true
}
```

### `api/index.php`

```php
<?php

/**
 * Vercel serverless entry point for Laravel.
 *
 * All non-static traffic is routed here via vercel.json.
 * Bootstraps Laravel and handles the request.
 */

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Redirect writable storage to /tmp on Vercel (Lambda filesystem is read-only)
if (getenv('APP_STORAGE_PATH')) {
    $storagePath = getenv('APP_STORAGE_PATH');
    $app->useStoragePath($storagePath);
    foreach (['framework/views', 'framework/cache/data', 'logs', 'app/livewire-tmp'] as $dir) {
        $full = $storagePath.'/'.$dir;
        if (!is_dir($full)) {
            @mkdir($full, 0755, true);
        }
    }
}

// Handle request through Laravel's HTTP kernel
$app->handleRequest(Request::capture());
```

### `.vercelignore`

```
.env
.git
.gitignore
.gitattributes
node_modules
frontend
tests
backup-php
storage/logs
storage/framework/cache
storage/framework/sessions
storage/framework/testing
phpunit.xml
.editorconfig
.dockerignore
Dockerfile
docker-entrypoint.sh
postcss.config.js
tailwind.config.js
vite.config.js
*.md
*.sql
package-lock.json
```

---

## Serverless Considerations

### Feature / Why It Changes

| Feature | Local | Vercel (serverless) |
|---|---|---|
| **Sessions** | `file` driver → `storage/framework/sessions` | Must use **`database`** driver (file writes lost between Lambda invocations) |
| **Cache** | `file` store → `storage/framework/cache` | Must use **`database`** or **`array`** store |
| **Queue workers** | `database` driver + `php artisan queue:listen` | **No persistent queue workers** on Vercel. Use **`sync`** driver for immediate execution, or an external queue service (SQS, Redis) |
| **Cron / scheduled tasks** | `php artisan schedule:run` via system cron | Use an external cron service (e.g. cron-job.org, GitHub Actions, Laravel Cloud) hitting a protected URL |
| **File uploads** | `storage/app/public/` or `uploads/` | **Not persistent** – files written to disk disappear after the request. Use **S3** (`MEDIA_DISK=s3`) or the existing DB-blob pattern (`php artisan images:migrate-to-db`) |
| **Blade views cache** | `storage/framework/views` | Compiled at runtime; redirected to `/tmp` via `APP_STORAGE_PATH` |
| **Livewire temp uploads** | `storage/app/livewire-tmp` | Redirected to `/tmp/storage/app/livewire-tmp` via `APP_STORAGE_PATH` |

### Spatie Media Library

The project uses Spatie Media Library. On Vercel:

- Set `MEDIA_DISK=s3` and configure AWS env vars for persistent file storage.
- Set `QUEUE_CONVERSIONS_BY_DEFAULT=false` so image conversions run synchronously (no queue workers).
- The existing `php artisan images:migrate-to-db` command can also migrate filesystem images into DB BLOBs as a fallback.

---

## Required Environment Variables (set in Vercel Dashboard)

| Variable | Example Value | Notes |
|---|---|---|
| `APP_KEY` | `base64:…` | Generate with `php artisan key:generate --show` |
| `APP_ENV` | `production` | |
| `APP_DEBUG` | `false` | |
| `APP_URL` | `https://rg-ambulance.vercel.app` | Your deployed URL |
| `APP_STORAGE_PATH` | `/tmp/storage` | Redirects writable paths to `/tmp` |
| `DB_CONNECTION` | `mysql` | |
| `DB_HOST` | `your-db-host` | |
| `DB_PORT` | `3306` | |
| `DB_DATABASE` | `rg_ambulance` | |
| `DB_USERNAME` | `your-user` | |
| `DB_PASSWORD` | `your-password` | |
| `SESSION_DRIVER` | `database` | Override the `file` default |
| `CACHE_STORE` | `database` | Override the `file` default |
| `QUEUE_CONNECTION` | `sync` | No workers on Vercel |
| `QUEUE_CONVERSIONS_BY_DEFAULT` | `false` | Spatie media conversions inline |
| `MEDIA_DISK` | `s3` | Persistent file uploads |
| `FILESYSTEM_DISK` | `s3` | Persistent file storage |
| `AWS_ACCESS_KEY_ID` | *(if using S3)* | |
| `AWS_SECRET_ACCESS_KEY` | *(if using S3)* | |
| `AWS_DEFAULT_REGION` | `us-east-1` | |
| `AWS_BUCKET` | `your-bucket` | |
| `MAIL_MAILER` | `smtp` | Keep your existing mail config |
| `MAIL_HOST` | `smtp.gmail.com` | |
| `MAIL_PORT` | `587` | |
| `MAIL_USERNAME` | *(your mail user)* | |
| `MAIL_PASSWORD` | *(your mail password)* | |
| `MAIL_ENCRYPTION` | `tls` | |
| `MAIL_FROM_ADDRESS` | `ebenezer.r@rgambulanceservice.com` | |
| `MAIL_FROM_NAME` | `RG Ambulance Service` | |

---

## Deployment Steps

### 1. Push to GitHub

```bash
cd R.G.-Ambulance-vercel
git init
git add .
git commit -m "Initial Vercel deployment"
git remote add origin https://github.com/YOUR_USER/R.G.-Ambulance-vercel.git
git push -u origin main
```

### 2. Import into Vercel

- Go to [vercel.com/new](https://vercel.com/new)
- Import the GitHub repository
- Vercel auto-detects the `vercel.json` config

### 3. Add Environment Variables

In the Vercel project dashboard → **Settings** → **Environment Variables**, add all variables from the table above.  
Mark `APP_KEY`, `DB_*`, `AWS_*` etc. as **"Available during Build"** so `php artisan config:cache` succeeds.

### 4. Deploy

- Vercel automatically runs the `buildCommand` from `vercel.json`:
  1. `composer install --no-dev --no-interaction --prefer-dist`
  2. `php artisan config:cache`
  3. `php artisan route:cache`
  4. `php artisan view:cache`
- After a successful build, the site goes live.

### 5. Post-Deploy

- Run `php artisan migrate` on your database (via a one-time run or external tool).
- If using S3 for media, run `php artisan storage:link` is **not** needed on Vercel (static files are handled by Vercel CDN).
- Test all routes, especially:
  - Filament admin panel
  - Authentication (login/register)
  - Contact form submission
  - Any file uploads (should use S3)
