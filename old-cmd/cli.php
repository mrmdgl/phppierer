<?php
// cli.php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Command line arguments
$argv = $_SERVER['argv'];
$command = isset($argv[1]) ? $argv[1] : 'help';

// Simple command handler
switch ($command) {
    case 'start':
        startServer($argv);
        break;
    case 'migrate':
        runMigrations();
        break;
    case 'help':
    default:
        showHelp();
        break;
}

function startServer($argv)
{
    $host = isset($argv[2]) ? $argv[2] : 'localhost';
    $port = isset($argv[3]) ? $argv[3] : '8000';
    $documentRoot = __DIR__ . '/';

    if (!filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
        echo "Invalid host.\n";
        exit(1);
    }

    if (!is_numeric($port) || $port < 1024 || $port > 65535) {
        echo "Invalid port. It should be a number between 1024 and 65535.\n";
        exit(1);
    }

    echo "Starting PHP built-in server on http://$host:$port...\n";
    $command = "php -S $host:$port -t $documentRoot";
    exec($command, $output, $return_var);

    if ($return_var !== 0) {
        echo "Failed to start server.\n";
        echo "Output:\n" . implode("\n", $output) . "\n";
        exit(1);
    }
    echo "Server started at http://$host:$port\n";
}

function runMigrations()
{
    echo "Running database migrations...\n";
    // Implement your migration logic here
    // For now, let's just simulate it
    echo "Migrations executed.\n";
}

function showHelp()
{
    echo "Available commands:\n";
    echo "  start [host] [port] - Start the PHP built-in server on the specified host and port (default: localhost:8000)\n";
    echo "  migrate - Run database migrations\n";
    echo "  help    - Show this help message\n";
}
