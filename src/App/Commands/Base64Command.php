<?php declare(strict_types=1);

namespace Automation\App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument, InputOption};
use symfony\Component\Console\Output\OutputInterface;
// use Automation\Core\Facades\Filesystem;

#[AsCommand(
    name: 'base64',
    description: 'Base64 decode/decode a text or file.',
    aliases: ['b64']
)]
class Base64Command extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Base64 encode/decode a text or file.');
        $this->addArgument('operation', InputArgument::REQUIRED);
        $this->addArgument('target', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $operation = $input->getArgument('operation');
        $target    = $input->getArgument('target');

        if (str_starts_with($operation, 'en') || str_starts_with($operation, 'de')) {
            if (file_exists($target)) {
                $target = file_get_contents($target);
            }
    
            $result = call_user_func(sprintf('base64_%scode', substr($operation, 0, 2)), $target);
    
            if (json_decode($result)) {
                $output->writeLn('<info>Success</info>');
                $output->writeLn(str_repeat("=", 32));
                dump(json_decode($result));
                $output->writeLn(str_repeat("=", 32));

                return Command::SUCCESS;
            }

            if ($result) {
                $output->writeLn([
                    '<info>Success</info>',
                    str_repeat("=", 32),
                    $result,
                    str_repeat("=", 32)
                ]);
    
                return Command::SUCCESS;
            }
        }       

        $output->writeLn('<error>Something went worng! Please check your command well.</error>');

        return Command::FAILURE;
    }
}