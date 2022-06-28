<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;
use Automation\Framework\Queue\Queueable;
use Automation\Framework\Notifications\Slack;

class CheckHackeronePrograms implements Queueable
{
    public function __construct(
        private Application $app
    ) {

    }

    public function execute(Slack $slack): bool
    {
        $message = $slack->send('A new program on HackerOne has launched!');

        if (false !== $message) {            
            return true;
        }

        return false;
    }
}