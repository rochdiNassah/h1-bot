<?php declare(strict_types=1);

namespace Automation\App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument};
use symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Automation\Core\Facades\Encoder;

#[AsCommand(
    name: 'detect-encoding',
    aliases: ['de']
)]
class DetectEncodingCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Detect the encoding of a text.');
        $this->addArgument('target', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        
        return Command::FAILURE;
    }
}