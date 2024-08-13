<?php
// clis/clis.php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$application = new Application('Custom CLI', '1.0.0');

// Define the start command
$startCommand = new Command('start');
$startCommand->setDescription('Start the PHP built-in server.')
    ->addArgument('host', InputArgument::OPTIONAL, 'The host to bind to', 'localhost')
    ->addArgument('port', InputArgument::OPTIONAL, 'The port to bind to', '8000')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $host = $input->getArgument('host');
        $port = $input->getArgument('port');
        $documentRoot = __DIR__ . '/../';

        if (!filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            $output->writeln("<error>Invalid host.</error>");
            exit(1);
        }

        if (!is_numeric($port) || $port < 1024 || $port > 65535) {
            $output->writeln("<error>Invalid port. It should be a number between 1024 and 65535.</error>");
            exit(1);
        }

        $output->writeln("Starting PHP built-in server on http://$host:$port...");
        $command = "php -S $host:$port -t $documentRoot";
        exec($command, $outputLines, $returnVar);

        if ($returnVar !== 0) {
            $output->writeln("<error>Failed to start server.</error>");
            $output->writeln("Output:\n" . implode("\n", $outputLines));
            exit(1);
        }
        $output->writeln("Server started at http://$host:$port");
    });

$application->add($startCommand);

// Define the migrate command
$migrateCommand = new Command('migrate');
$migrateCommand->setDescription('Run database migrations.')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $output->writeln("Running database migrations...");
        // Implement migration logic here
        $output->writeln("Migrations executed.");
    });

$application->add($migrateCommand);

// Define the help command
$helpCommand = new Command('help');
$helpCommand->setDescription('Show help information.')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $output->writeln("Available commands:");
        $output->writeln("  start   - Start the PHP built-in server");
        $output->writeln("  migrate - Run database migrations");
        $output->writeln("  help    - Show this help message");
    });

$application->add($helpCommand);

// Run the application
$application->run();
