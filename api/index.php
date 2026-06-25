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

// On Vercel Lambda the filesystem is read-only except /tmp.
// Redirect writable paths to /tmp so Blade cache, logs, Livewire
// temp uploads, etc. survive during the function lifetime.
if (getenv('VERCEL') || getenv('APP_STORAGE_PATH')) {
    $storagePath = getenv('APP_STORAGE_PATH') ?: '/tmp/storage';
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
