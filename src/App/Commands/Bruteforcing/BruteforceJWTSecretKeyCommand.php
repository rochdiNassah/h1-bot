<?php declare(strict_types=1);

namespace Automation\App\Commands\Bruteforcing;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Automation\Core\Facades\Encoder;

#[AsCommand(
    name: 'bf:jwt'
)]
class BruteforceJWTSecretKeyCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Brute force JWT secret key.');
        $this->addArgument('target', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $string = $input->getArgument('target');

        if (is_null($string)) {
            $string = $this->getHelper('question')
                ->ask(
                    $input,
                    $output,
                    app(Question::class, ['<comment>Enter the token you want to brute force its secret key: </comment>'])
                );
            
            $output->writeLn('');
        }

        if (is_null($string)) {
            $output->writeLn('<error>You provided an empty string.</error>');

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}