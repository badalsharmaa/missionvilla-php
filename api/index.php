<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Ensure writable directories exist in Vercel serverless /tmp environment
$tmpDirs = [
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
    '/tmp/logs',
];
foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Set environment variables for serverless execution
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');

// Determine if the application is in maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->handleRequest(Request::capture());
