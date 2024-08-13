param (
    [string]$command
)

if (-not $command) {
    Write-Host "No command specified. Use 'help' for usage information."
    exit 1
}

# Forward the command to the PHP CLI script
php clis/cli.php $command
