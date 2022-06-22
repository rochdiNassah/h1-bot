<?php declare(strict_types=1);

namespace Automation\App\Commands\Alerts;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputOption};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

#[AsCommand(
    name: 'monitor-packets'
)]
class MonitorPacketsCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Monitor incoming packets.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        socket_connect($socket, '0.0.0.0', 2001);

        while (true) {
            socket_write($socket, 'ls', 2);

            sleep(1);
        }

        socket_close($socket);

        return Command::FAILURE;
    }
}