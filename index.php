<?php
// index.php

// Include configuration
$config = require 'config.php';

// Access database configuration
$dbHost = $config['database']['host'];
$dbName = $config['database']['database'];
$dbUser = $config['database']['user'];
$dbPassword = $config['database']['password'];

// Access application settings
$appEnv = $config['app']['env'];
$appDebug = $config['app']['debug'];

// Debugging: Print out configuration values (optional, for troubleshooting)
//var_dump($dbHost, $dbName, $dbUser, $dbPassword);

// Validate that required configuration values are set, except for the password
if (empty($dbHost) || empty($dbName) || empty($dbUser)) {
    throw new Exception('Database configuration is incomplete. Please check your .env file.');
}

// Optionally log a warning if the password is empty (for production environments)
if (empty($dbPassword)) {
    error_log('Warning: Database password is empty. Make sure this is intentional.');
}

// Example: Connecting to a database
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for PDO errors
    echo 'Database connection successful!';
} catch (PDOException $e) {
    // Log detailed error in production
    if ($appDebug === 'true') {
        echo 'Connection failed: ' . $e->getMessage();
    } else {
        echo 'Connection failed: Unable to connect to the database.';
        // You can also log this error to a file or monitoring system
        error_log($e->getMessage());
    }
}
