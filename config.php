<?php
// config.php

require_once __DIR__ . '/vendor/autoload.php'; // Composer autoload

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Default values (can be overridden by .env file)
$defaultConfig = [
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'database' => $_ENV['DB_DATABASE'] ?? 'squehub',
        'user' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
    ],
    'app' => [
        'env' => $_ENV['APP_ENV'] ?? 'development',
        'debug' => $_ENV['APP_DEBUG'] ?? 'true',
    ],
];

// Load environment variables and apply defaults
$config = [
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? $defaultConfig['database']['host'],
        'database' => $_ENV['DB_DATABASE'] ?? $defaultConfig['database']['database'],
        'user' => $_ENV['DB_USER'] ?? $defaultConfig['database']['user'],
        'password' => $_ENV['DB_PASSWORD'] ?? $defaultConfig['database']['password'],
    ],
    'app' => [
        'env' => $_ENV['APP_ENV'] ?? $defaultConfig['app']['env'],
        'debug' => $_ENV['APP_DEBUG'] ?? $defaultConfig['app']['debug'],
    ],
];

// Validation
if (empty($config['database']['host']) || empty($config['database']['database']) || empty($config['database']['user'])) {
    error_log('Warning: Database configuration is incomplete. Some default values are being used.');
}

return $config;
