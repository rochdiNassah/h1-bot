<?php declare(strict_types=1);

namespace Automation\App\Commands\Encoding;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Automation\Core\Facades\Encoder;

#[AsCommand(
    name: 'split-jwt',
    aliases: ['sj']
)]
class SplitJWTCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Split a JWT parts.');
        $this->addArgument('string', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->getFormatter()->setStyle('red', app(OutputFormatterStyle::class, ['red']));
        $output->getFormatter()->setStyle('green', app(OutputFormatterStyle::class, ['green']));
        $output->getFormatter()->setStyle('yellow', app(OutputFormatterStyle::class, ['yellow']));
        $output->getFormatter()->setStyle('bright-magenta', app(OutputFormatterStyle::class, ['bright-magenta']));
        $output->getFormatter()->setStyle('cyan', app(OutputFormatterStyle::class, ['cyan']));

        $string = $input->getArgument('string');

        if (is_null($string)) {
            $string = $this->getHelper('question')
                ->ask(
                    $input,
                    $output,
                    app(Question::class, ['<comment>Enter the token you want to split: </comment>'])
                );
            
            $output->writeLn('');
        }

        if (is_null($string)) {
            $output->writeLn('<error>You provided an empty string.</error>');

            return Command::FAILURE;
        }

        $result = explode('.', $string);

        if (!is_array($result)) {
            $output->writeLn('<error>Failed to split the provided JWT.</error>');

            return Command::FAILURE;
        }

        $result[0] = sprintf('Header: <red>%s</red>', $result[0]);
        $result[1] = sprintf('Payload: <bright-magenta>%s</bright-magenta>', $result[1]);
        $result[2] = sprintf('Signature: <cyan>%s</cyan>', $result[2]);

        $output->writeLn([
            str_repeat('=', 32),
            ...$result,
            str_repeat('=', 32)
        ]);

        return Command::SUCCESS;
    }
}
