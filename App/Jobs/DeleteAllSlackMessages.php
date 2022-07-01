<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;
use Automation\Framework\Interfaces\JobInterface;
use Automation\Framework\Notifications\Slack;

class DeleteAllSlackMessages implements JobInterface
{
    public function __construct(
        private Application $app
    ) {
        
    }

    public function __invoke(Slack $slack)
    {
        if (false !== $slack->channel('debug')->deleteAll()) {
            $slack->send(sprintf('Deleted all messages from "debug" channel at %s!', date('H:i')));

            return true;
        }

        throw new \Exception('Failed to delete messages from "debug" channel!');
    }
}