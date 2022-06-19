<?php declare(strict_types=1);

namespace Automation\App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputArgument, InputOption};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Automation\Core\Facades\Encoder;

#[AsCommand(
    name: 'encode',
    aliases: ['e']
)]
class EncodeCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('Encode a text or file.');
        $this->addArgument('target', InputArgument::OPTIONAL);
        $this->addOption('as', null, InputOption::VALUE_REQUIRED, 'Encode the given data as', 'base64');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (null === $input->getArgument('target')) {
            $question_helper = $this->getHelper('question');

            $question = new Question('<comment>Enter the text or file path you want to encode: </comment>');
    
            $target = $question_helper->ask($input, $output, $question);
    
            $output->writeLn('');
        } else {
            $target = $input->getArgument('target');
        }

        $as = $input->getOption('as');

        $result = false;

        if (!is_null($as)) {
            if (!in_array($as, Encoder::supportedTypes())) {
                $output->writeLn("<error>\"{$as}\" is not a supported encoding type!</error>");

                return Command::FAILURE;
            }
            if (file_exists($target)) {
                $target = file_get_contents($target);
            }

            $result = Encoder::encode($target, $as);

            if ($result) {
                $output->writeLn([
                    "<info>Data encoded as \"{$as}\" successfully!</info>",
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
