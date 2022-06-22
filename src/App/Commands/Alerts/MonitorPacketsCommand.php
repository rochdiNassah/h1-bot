<?php declare(strict_types=1);

namespace Automation\App\Commands\Alerts;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputOption};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Automation\Core\Facades\Encoder;

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
        play_audio('notification2.mp3');

        return Command::SUCCESS;
    }
}