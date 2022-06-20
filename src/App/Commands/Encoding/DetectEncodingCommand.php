<?php declare(strict_types=1);

namespace Automation\App\Commands\Encoding;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument};
use Symfony\Component\Console\Output\OutputInterface;
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
        $this->setHelp('Detect the encoding of a string.');
        $this->addArgument('target', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $target = $input->getArgument('target');

        if (is_null($target)) {
            $target = $this->getHelper('question')
                ->ask(
                    $input,
                    $output,
                    app(Question::class, ['<comment>Enter the text you want to detect its encoding: </comment>'])
                );
            
            $output->writeLn('');
        }

        if (is_null($target)) {
            $output->writeLn('<error>Target text mustn\'t be empty.</error>');

            return Command::FAILURE;
        }

        $result = Encoder::detect($target);

        if (false === $result) {
            $output->writeLn('<error>Failed to detect the encoding.</error>');

            return Command::FAILURE;
        }

        $output->writeLn([
            str_repeat('=', 32),
            $result,
            str_repeat('=', 32)
        ]);

        return Command::SUCCESS;
    }
}
