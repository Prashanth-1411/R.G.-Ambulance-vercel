<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

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

$app->handleRequest(Illuminate\Http\Request::capture());
