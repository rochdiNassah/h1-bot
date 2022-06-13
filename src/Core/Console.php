<?php declare(strict_types=1);

namespace Automation\Core;

use Symfony\Component\Console\Application as SymfonyConsole;

class Console
{
    public function __construct(
        private Application $app,
        private SymfonyConsole $console
    ) {
        
    }

    public function run(): void
    {
        $this->console->run();
    }
}