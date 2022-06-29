<?php declare(strict_types=1);

namespace Automation\Framework\Console;

use Automation\Framework\Application;

class Console
{
    public function __construct(
        private int $pid,
        private Application $app
    ) {
        
    }

    public function signal(int $sig): bool
    {
        return posix_kill($this->pid, $sig);
    }
}