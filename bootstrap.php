<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Error Logging Configuration
$logFile = __DIR__ . '/php_errors.log';
ini_set('log_errors', '1');
ini_set('error_log', $logFile);
ini_set('display_errors', '0'); // Hide from users
error_reporting(E_ALL);

// Ensure log file exists and is writable
if (!file_exists($logFile)) {
    touch($logFile);
    chmod($logFile, 0666);
}

$capsule = new Capsule;

try {
    $dbPath = __DIR__ . '/database/database.sqlite';
    
    // Auto-create directory if missing
    if (!is_dir(dirname($dbPath))) {
        mkdir(dirname($dbPath), 0755, true);
    }

    $capsule->addConnection([
        'driver'   => 'sqlite',
        'database' => $dbPath,
        'prefix'   => '',
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();
} catch (\Exception $e) {
    error_log("[TaskFlow Bootstrap Error] " . $e->getMessage());
    if (php_sapi_name() === 'cli') {
        echo "❌ Database Error: " . $e->getMessage() . "\n";
    } else {
        http_response_code(500);
        die("Backend configuration error. Please check server logs.");
    }
}
