<?php declare(strict_types=1);

namespace Automation\App\Commands\Misc;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Automation\Core\Facades\Encoder;

#[AsCommand(
    name: 'strlen',
    aliases: ['sl']
)]
class StrlenCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Get the length of a string.');
        $this->addArgument('string', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $string = $input->getArgument('string');

        if (is_null($string)) {
            $string = $this->getHelper('question')
                ->ask(
                    $input,
                    $output,
                    app(Question::class, ['<comment>Enter the text you want to get its length: </comment>'])
                );
            
            $output->writeLn('');
        }

        if (is_null($string)) {
            $output->writeLn('<error>You provided an mepty string</error>');

            return Command::FAILURE;
        }

        $result = strlen($string);

        $output->writeLn([
            str_repeat('=', 32),
            $result,
            str_repeat('=', 32)
        ]);

        return Command::SUCCESS;
    }
}
