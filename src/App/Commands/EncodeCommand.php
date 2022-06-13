<?php declare(strict_types=1);

namespace Automation\App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument, InputOption};
use symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'encode',
    aliases: ['e']
)]
class EncodeCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Encode a text or file.');
        $this->addArgument('target', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $target = $input->getArgument('target');

        if (file_exists($target)) {
            $target = file_get_contents($target);
        }

        $result = base64_encode($target);

        if ($result) {
            $output->writeLn([
                '<info>Data encoded successfully!</info>',
                str_repeat("=", 32),
                $result,
                str_repeat("=", 32)
            ]);

            return Command::SUCCESS;
        }

        $output->writeLn('<error>Something went worng! Please check your command well.</error>');

        return Command::FAILURE;
    }
}