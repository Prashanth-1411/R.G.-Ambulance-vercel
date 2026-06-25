<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

if (getenv('APP_STORAGE_PATH')) {
    $app->useStoragePath(getenv('APP_STORAGE_PATH'));
}

$app->handleRequest(Illuminate\Http\Request::capture());
