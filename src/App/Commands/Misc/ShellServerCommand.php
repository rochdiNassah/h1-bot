<?php declare(strict_types=1);

namespace Automation\App\Commands\Misc;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument};
use Symfony\Component\Console\Output\OutputInterface;
use Automation\Core\Facades\Filesystem;

#[AsCommand(
    name: 'shell-server',
)]
class ShellServerCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Play and audio from the filesystem.');
        $this->addArgument('path', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');

        if (is_null($path)) {
            $output->writeLn('<error>You didn\'t provide the audio path.</error>');

            return Command::FAILURE;
        }

        $path = (string) Filesystem::to('resources/audio')->to($path);

        if (!file_exists($path)) {
            $output->writeLn(sprintf('<error>"%s" does not exist.</error>', $path));

            return Command::FAILURE;
        }

        shell_exec(sprintf('cvlc --play-and-exit %s 2>/dev/null', $path));

        return Command::SUCCESS;
    }
}
