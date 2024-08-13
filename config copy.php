<?php
// config.php

require_once __DIR__ . '/vendor/autoload.php'; // Composer autoload

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Default values
$defaultConfig = [
    'database' => [
        'host' => 'localhost',
        'database' => 'squehub',
        'user' => 'root',
        'password' => '',
    ],
    'app' => [
        'env' => 'development',
        'debug' => 'true',
    ],
];

// Load environment variables and apply defaults
$config = [
    'database' => [
        'host' => getenv('DB_HOST') ?: $defaultConfig['database']['host'],
        'database' => getenv('DB_DATABASE') ?: $defaultConfig['database']['database'],
        'user' => getenv('DB_USER') ?: $defaultConfig['database']['user'],
        'password' => getenv('DB_PASSWORD') ?: $defaultConfig['database']['password'],
    ],
    'app' => [
        'env' => getenv('APP_ENV') ?: $defaultConfig['app']['env'],
        'debug' => getenv('APP_DEBUG') ?: $defaultConfig['app']['debug'],
    ],
];

// Validation
if (empty($config['database']['host']) || empty($config['database']['database']) || empty($config['database']['user'])) {
    error_log('Warning: Database configuration is incomplete. Some default values are being used.');
}

return $config;
