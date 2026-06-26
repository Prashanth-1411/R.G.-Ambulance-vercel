<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$storagePath = getenv('APP_STORAGE_PATH') ?: '/tmp/storage';
$app->useStoragePath($storagePath);
foreach (['framework/views', 'framework/cache/data', 'framework/sessions', 'logs', 'app/livewire-tmp', 'app/public'] as $dir) {
    $full = $storagePath.'/'.$dir;
    if (!is_dir($full)) {
        @mkdir($full, 0755, true);
    }
}

try {
    $app->handleRequest(Illuminate\Http\Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
}
