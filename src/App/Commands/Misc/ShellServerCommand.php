<?php declare(strict_types=1);

namespace Automation\App\Commands\Misc;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface};
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'shell-server',
)]
class ShellServerCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Start a TCP server listening for commands to run.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        set_time_limit(0);
        ob_implicit_flush();

        $address = '0.0.0.0';
        $port    = 2001;

        if (false === ($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))) {
            $outpur->writeLn('<error>Failed to create the socket.</error>');

            return Command::FAILURE;
        }
        if (false === socket_bind($socket, $address, $port)) {
            $outpur->writeLn('<error>Failed to bind the socket.</error>');

            return Command::FAILURE;
        }
        if (false === socket_listen($socket, 16)) {
            $outpur->writeLn('<error>Failed to listen.</error>');

            return Command::FAILURE;
        }

        do {
            if (false === ($msg_sock = socket_accept($socket))) {
                $outpur->writeLn('<error>Failed to accept a connection.</error>');

                break;
            }

            do {
                if (false === ($buffer = socket_read($msg_sock, 2048, PHP_NORMAL_READ))) {
                    $outpur->writeLn('<error>Failed to read from a connection.</error>');

                    break 2;
                }

                shell_exec($buffer);

                socket_wite($msg_sock, 'success', 8);

                socket_close($msg_sock);
            } while (true);
        } while (true);

        socket_close($socket);

        return Command::SUCCESS;
    }
}
