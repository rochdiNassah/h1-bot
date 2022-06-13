<?php declare(strict_types=1);

namespace Automation\App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument, InputOption};
use symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'decode',
    aliases: ['d']
)]
class DecodeCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Decode a text or file.');
        $this->addArgument('target', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $target = $input->getArgument('target');

        if (file_exists($target)) {
            $target = file_get_contents($target);
        }

        $result = base64_decode($target);

        if (json_decode($result)) {
            $output->writeLn('<info>Data decoded and converted to json successfully!</info>');
            $output->writeLn(str_repeat("=", 32));
            dump(json_decode($result));
            $output->writeLn(str_repeat("=", 32));

            return Command::SUCCESS;   
        }

        if ($result) {
            $output->writeLn([
                '<info>Data decoded successfully!</info>',
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