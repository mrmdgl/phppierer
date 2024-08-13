<?php
// cli.php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

// Command line arguments
$argv = $_SERVER['argv'];
$command = isset($argv[1]) ? $argv[1] : 'help';

// Simple command handler
switch ($command) {
    case 'start':
        startServer();
        break;
    case 'migrate':
        runMigrations();
        break;
    case 'help':
    default:
        showHelp();
        break;
}

/*
function startServer()
{
    echo "Starting PHP built-in server...\n";
    $host = 'localhost';
    $port = '8000';
    $documentRoot = __DIR__ . '/../';
    exec("php -S $host:$port -t $documentRoot", $output, $return_var);
    if ($return_var !== 0) {
        echo "Failed to start server.\n";
        exit(1);
    }
    echo "Server started at http://$host:$port\n";
}
*/

function startServer()
{
    global $argv;
    $host = isset($argv[2]) ? $argv[2] : 'localhost';
    $port = isset($argv[3]) ? $argv[3] : '8000';
    $documentRoot = __DIR__ . '/../';
    
    echo "Starting PHP built-in server on http://$host:$port...\n";
    exec("php -S $host:$port -t $documentRoot", $output, $return_var);
    
    if ($return_var !== 0) {
        echo "Failed to start server.\n";
        exit(1);
    }
    echo "Server started at http://$host:$port\n";
}


function runMigrations()
{
    echo "Running database migrations...\n";
    // Here you would implement your migration logic
    // For now, let's just simulate it
    echo "Migrations executed.\n";
}

function showHelp()
{
    echo "Available commands:\n";
    echo "  start   - Start the PHP built-in server\n";
    echo "  migrate - Run database migrations\n";
    echo "  help    - Show this help message\n";
}
