<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;
use Automation\Framework\Interfaces\JobInterface;
use Automation\Framework\Notifications\Slack;

class CheckHackeronePrograms implements JobInterface
{
    public function __construct(
        private Application $app
    ) {

    }

    public function __invoke(Slack $slack): bool
    {
        $message = $slack->send('A new program on HackerOne has launched!');

        if (false !== $message) {            
            return true;
        }

        return false;
    }
}
